import time
import random
import requests

BASE_URL = "http://127.0.0.1:8000/api"
API_KEY = "KUNCI_AYAM_123"

HEADERS = {
    "X-API-KEY": API_KEY,
    "Content-Type": "application/json",
    "Accept": "application/json"
}

DEVICES = ["DHT22_1", "DHT22_2"]

total_masuk = {d: 0 for d in DEVICES}
total_keluar = {d: 0 for d in DEVICES}

print("=== SIMULATOR ULTRASONIC START ===")

def simulasi_ultrasonic():
    """
    Return:
    'MASUK', 'KELUAR', atau None
    """

    peluang = random.random()

    if peluang < 0.4:
        print("  [ULTRASONIC] DEPAN -> BELAKANG (AYAM MASUK)")
        time.sleep(0.5)
        return "MASUK"

    elif peluang < 0.7:
        print("  [ULTRASONIC] BELAKANG -> DEPAN (AYAM KELUAR)")
        time.sleep(0.5)
        return "KELUAR"

    else:
        return None


while True:
    for device in DEVICES:

        suhu = round(random.uniform(25, 35), 2)

        hasil = simulasi_ultrasonic()

        ayam_terdeteksi = hasil is not None

        if hasil == "MASUK":
            total_masuk[device] += 1

        elif hasil == "KELUAR":
            total_keluar[device] += 1

        payload = {
            "device_id": device,
            "temperature": suhu,
            "chicken_detected": ayam_terdeteksi,
            "chicken_in": total_masuk[device],
            "chicken_out": total_keluar[device]
        }

        try:
            res = requests.post(f"{BASE_URL}/ingest", json=payload, headers=HEADERS)

            print(f"[SENSOR] {device}")
            print(f"  -> Suhu: {suhu}°C")
            print(f"  -> Deteksi: {ayam_terdeteksi}")
            print(f"  -> Total Masuk: {total_masuk[device]}")
            print(f"  -> Total Keluar: {total_keluar[device]}")
            print(f"  -> Status API: {res.status_code}")
            print(f"  -> Response: {res.text}\n")

        except Exception as e:
            print(f"[ERROR SENSOR {device}] {e}")

    print("===== LOOP SELESAI =====\n")
    time.sleep(5)