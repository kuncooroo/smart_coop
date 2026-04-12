import time
import requests
import datetime

# Konfigurasi Endpoint Laravel
API_BASE = "http://127.0.0.1:8000/api"
API_KEY = "KUNCI_AYAM_123"

# Parameter untuk GET request (API Key)
params = {'api_key': API_KEY}
headers = {'Content-Type': 'application/json'}

print("=== Smart Chicken Coop Worker ===")
print(f"Menunggu perintah (polling) dari: {API_BASE}/commands/get")
print("Tekan Ctrl+C untuk menghentikan.\n")

def poll_command():
    try:
        # 1. Mengambil perintah pending dari Laravel
        req = requests.get(f"{API_BASE}/commands/get", params=params)
        
        # Cek jika server merespon dengan sukses
        if req.status_code == 200:
            res = req.json()
            
            if res.get('has_command'):
                cmd_data = res['data']
                cmd_id = cmd_data['id']
                device = cmd_data['device_id']
                action = cmd_data['command_type']
                
                print(f"[{datetime.datetime.now().strftime('%H:%M:%S')}]")
                print(f"[-] Perintah Diterima: {action} untuk {device}")
                
                # --- SIMULASI EKSEKUSI HARDWARE ---
                if action == "OPEN_DOOR":
                    print(f"[-] Menjalankan SERVO: Membuka Pintu {device}...")
                    time.sleep(2) # Simulasi durasi gerak servo
                elif action == "CLOSE_DOOR":
                    print(f"[-] Menjalankan SERVO: Menutup Pintu {device}...")
                    time.sleep(2)
                elif action == "TOGGLE_LIGHT":
                    print(f"[-] Menjalankan RELAY: Mengubah status Lampu {device}...")
                    time.sleep(1)
                
                # 2. Melaporkan ke Laravel bahwa perintah sudah selesai dieksekusi
                update_payload = {
                    "id": cmd_id, 
                    "device_id": device, 
                    "command_type": action,
                    "api_key": API_KEY # Sertakan api_key jika middleware membutuhkannya
                }
                
                update_req = requests.post(f"{API_BASE}/commands/update", json=update_payload, params=params)
                
                if update_req.status_code == 200:
                    print("[+] Status berhasil diperbarui di database Laravel.\n")
                else:
                    print(f"[!] Gagal memperbarui status: {update_req.text}\n")
                    
        elif req.status_code == 401:
            print("[!] Error: API Key tidak valid (Unauthorized).")
        else:
            print(f"[!] Server Error: {req.status_code}")

    except requests.exceptions.ConnectionError:
        # Diam saja atau print sekali jika server mati
        pass 
    except Exception as e:
        print(f"Kesalahan Worker: {e}")

def check_automation_rules():
    """
    Contoh logika otomatisasi di sisi Worker (Edge Computing)
    Misal: Tutup pintu otomatis jam 18:00
    """
    now = datetime.datetime.now()
    if now.hour == 18 and now.minute == 0 and now.second < 5:
        print("[Otomatisasi] Waktunya menutup semua pintu kandang (Maghrib).")
        # Di sini Anda bisa memanggil fungsi hardware langsung

while True:
    check_automation_rules()
    poll_command()
    time.sleep(3) # Cek perintah ke server setiap 3 detik