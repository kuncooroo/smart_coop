import time
import random
import requests
import json

# Konfigurasi Endpoint Laravel
# Jika menjalankan 'php artisan serve', default port adalah 8000
API_URL = "http://127.0.0.1:8000/api/ingest" 
API_KEY = "KUNCI_AYAM_123"

# Header keamanan untuk Laravel
headers = {
    'X-API-KEY': API_KEY,
    'Content-Type': 'application/json',
    'Accept': 'application/json'
}

devices = ["kandang_1", "kandang_2", "kandang_3"]
total_ayam_masuk = {d: 0 for d in devices}
total_ayam_keluar = {d: 0 for d in devices}

print("=== Smart Chicken Coop Simulator ===")
print(f"Mengirim data ke: {API_URL}")
print("Tekan Ctrl+C untuk menghentikan.\n")

while True:
    for device in devices:
        try:
            # 1. Simulasi Sensor Suhu (15.0 - 35.0 Celcius)
            suhu = round(random.uniform(15.0, 35.0), 2)
            
            # 2. Simulasi YOLO mendeteksi ayam (30% kemungkinan ada ayam)
            ayam_terdeteksi = random.random() < 0.3 
            
            # 3. Simulasi perhitungan ayam masuk/keluar
            masuk_sekarang = random.randint(0, 2) if ayam_terdeteksi else 0
            keluar_sekarang = random.randint(0, 2) if ayam_terdeteksi else 0
            
            total_ayam_masuk[device] += masuk_sekarang
            total_ayam_keluar[device] += keluar_sekarang

            # Payload JSON sesuai dengan struktur tabel di Laravel
            payload = {
                "device_id": device,
                "temperature": suhu,
                "chicken_detected": ayam_terdeteksi,
                "chicken_in": total_ayam_masuk[device],
                "chicken_out": total_ayam_keluar[device]
            }

            # Mengirim data ke Laravel
            response = requests.post(API_URL, json=payload, headers=headers)
            
            if response.status_code == 200:
                print(f"[{device}] Terkirim! Suhu: {suhu}C | YOLO: {ayam_terdeteksi} | Total In: {total_ayam_masuk[device]}")
            else:
                print(f"[{device}] Gagal! Status: {response.status_code} | Pesan: {response.text}")

        except requests.exceptions.ConnectionError:
            print("Gagal koneksi ke server Laravel. Pastikan 'php artisan serve' sedang berjalan.")
        except Exception as e:
            print(f"Terjadi kesalahan: {e}")
            
    time.sleep(5) # Jeda pengiriman setiap 5 detik