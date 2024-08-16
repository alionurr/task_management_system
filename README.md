# Projeyi Klonlama ve Kurulum Adımları

Bu adımlar, projenizi yerel ortamınızda kurup çalıştırmak için izlenmesi gereken talimatları içermektedir.

## 1. Projeyi Klonlayın

```bash
git clone <proje-repo-url>
cd <proje-klasör-ismi>
```

## 2. Composer Bağımlılıklarını Yükleyin

```bash
composer install
```

## 3. .env Dosyasını Oluşturun

`.env` dosyasını oluşturun ve gerekli konfigürasyonları yapın:

```bash
cp .env.example .env
```

## 4. Projeyi Sail ile Ayağa Kaldırın

```bash
./vendor/bin/sail up -d
```

## 5. Uygulama Anahtarını Oluşturun

```bash
./vendor/bin/sail artisan key:generate
```

## 6. JWT Secret Keyini Oluşturun

```bash
./vendor/bin/sail artisan jwt:secret
```

## 7. Veritabanını Migrasyonlar ve Seed ile Oluşturun

```bash
./vendor/bin/sail artisan migrate --seed
```

## 8. Redis Kuyruğunu Çalıştırın

```bash
./vendor/bin/sail queue:work redis
```

## 9. Postman

Repoda bulunan ``task_management_system_api_requests.postman_collection.json`` dosyası ile postman üzerinden test edebilirsiniz.


