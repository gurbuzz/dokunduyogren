# DokunDuyOgren

DokunDuyOgren, görme engelli çocuklar için etkileşimli bir öğrenme platformudur. Bu proje, eğitimcilerin kitaplar oluşturup sayfalar ekleyerek çocukların öğrenme deneyimini zenginleştirmelerine olanak tanır. Kullanıcılar, sayfalara görseller ekleyip sesli etiketler atayabilir ve bu etiketler QR kodlar ile erişilebilir hale getirilebilir.

## Özellikler

- **Kitap Oluşturma:** Eğitimciler yeni kitaplar oluşturabilir ve bu kitaplara sayfalar ekleyebilir.
- **Sayfa Ekleme:** Kitaplara görseller, metinler ve sesli anlatımlar eklenebilir.
- **Sesli Etiketleme:** Sayfalardaki görsellere sesli etiketler eklenebilir.
- **QR Kod Entegrasyonu:** Sayfalara QR kodlar eklenerek mobil uygulama üzerinden erişim sağlanabilir.
- **Kullanıcı Yönetimi:** Eğitimciler ve öğrenciler için kullanıcı hesapları oluşturulabilir ve yönetilebilir.

## Kurulum

Projeyi yerel ortamınızda çalıştırmak için aşağıdaki adımları izleyin:

### Gereksinimler

- PHP 7.4 veya daha yeni bir sürüm
- Composer
- Laravel 8.x
- PostgreSQL

### Adımlar

1. **Depoyu klonlayın:**
    ```bash
    git clone https://github.com/kullanici_adiniz/dokunduuyogren.git
    cd dokunduuyogren
    ```

2. **Gerekli bağımlılıkları yükleyin:**
    ```bash
    composer install
    npm install
    npm run dev
    ```

3. **.env dosyasını yapılandırın:**
    `.env.example` dosyasını kopyalayarak `.env` dosyasını oluşturun ve gerekli veritabanı yapılandırmalarını yapın.
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Veritabanını oluşturun ve migrasyonları çalıştırın:**
    ```bash
    php artisan migrate
    php artisan db:seed
    ```

5. **Sunucuyu başlatın:**
    ```bash
    php artisan serve
    ```

6. **Tarayıcınızda projeyi açın:**
    `http://localhost:8000`

## Kullanım

### Kitap Oluşturma ve Sayfa Ekleme

1. **Kitap Oluşturma:**
    - Ana sayfada "Kitap Ekle" butonuna tıklayın.
    - Kitap başlığı, yazar adı ve açıklama gibi bilgileri girin.
    - Kaydet butonuna tıklayarak kitabı oluşturun.

2. **Sayfa Ekleme:**
    - Kitap listesinde, sayfa eklemek istediğiniz kitabı seçin.
    - "Sayfa Ekle" butonuna tıklayın.
    - Sayfa adı, kategori ve etiket gibi bilgileri girin.
    - Görsel ekleyin ve "İleri" butonuna tıklayın.
    - QR kod ekleme ekranında QR kodu ekleyin ve kaydedin.

3. **Sesli Etiketleme:**
    - Sayfa üzerinde etiketlemek istediğiniz alanı seçin.
    - Etiket metnini girin ve kaydedin.



