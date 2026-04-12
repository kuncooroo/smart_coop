import time
import requests

BASE_URL = "http://127.0.0.1:8000/api"
API_KEY = "KUNCI_AYAM_123"

HEADERS = {
    "X-API-KEY": API_KEY,
    "Content-Type": "application/json",
    "Accept": "application/json"
}

def send_log(category, action, description, status="info"):
    """
    Fungsi untuk mengirim log aktivitas ke Laravel
    Kategori: 'system' atau 'device'
    Status: 'success', 'danger', 'warning', 'info'
    """
    try:
        payload = {
            "category": category,
            "action": action,
            "description": description,
            "status": status
        }
        res = requests.post(
            f"{BASE_URL}/logs", 
            json=payload,
            headers=HEADERS,
            timeout=5
        )
        if res.status_code == 201 or res.status_code == 200:
            print(f"   [LOG] Berhasil mencatat: {action}")
        else:
            print(f"   [LOG] Gagal kirim log: {res.status_code}")
    except Exception as e:
        print(f"   [LOG ERROR] {e}")

def get_command(device_id):
    try:
        res = requests.get(
            f"{BASE_URL}/commands/{device_id}",
            headers=HEADERS,
            timeout=5
        )
        
        if res.status_code != 200:
            return None

        data = res.json()
        if data.get("has_command") and data.get("data"):
            return data["data"]
            
        return None
    except Exception as e:
        print(f"[ERROR GET CMD] {device_id}: {e}")
        return None

def execute_command(cmd):
    device_id = cmd.get("device_id")
    command = cmd.get("command_type")
    cmd_id = cmd.get("id")

    print(f"\n[!] MENERIMA PERINTAH: {device_id} | {command}")
    
    log_msg = ""
    status_execution = "success"

    try:
        if "SERVO" in device_id:
            if command == "OPEN_DOOR":
                print("  -> Membuka Pintu...")
                time.sleep(1)
                log_msg = f"Akses diberikan: Pintu {device_id} terbuka."
            elif command == "CLOSE_DOOR":
                print("  -> Menutup Pintu...")
                time.sleep(1)
                log_msg = f"Keamanan: Pintu {device_id} dikunci kembali."

        elif "LAMP" in device_id:
            if command == "LIGHT_ON":
                print("  -> Menghidupkan Lampu...")
                log_msg = f"Lampu {device_id} dinyalakan."
            elif command == "LIGHT_OFF":
                print("  -> Mematikan Lampu...")
                log_msg = f"Lampu {device_id} dimatikan."
        
        send_log("device", command, log_msg, "success")

    except Exception as e:
        status_execution = "danger"
        send_log("system", "HARDWARE_ERROR", f"Gagal kontrol {device_id}: {str(e)}", "danger")
        
    try:
        payload = {
            "id": cmd_id,
            "device_id": device_id,
            "command_type": command
        }
        res = requests.post(
            f"{BASE_URL}/commands/update",
            json=payload,
            headers=HEADERS
        )
        print(f"  -> Update Command Status: {res.status_code}")
    except Exception as e:
        print(f"  -> ❌ Gagal update status di database: {e}")

DEVICES = ["SERVO_1", "LAMP_1", "SERVO_2", "LAMP_2"]

print("=== WORKER STARTING WITH LOGGING SYSTEM ===")
print(f"Target API: {BASE_URL}")

while True:
    for device in DEVICES:
        cmd = get_command(device)
        if cmd:
            execute_command(cmd)
    
    time.sleep(2)