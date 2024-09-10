# DokunDuyOgren

DokunDuyOgren, görme engelli çocuklar için etkileşimli bir öğrenme platformudur. Bu proje, eğitimcilerin kitaplar oluşturup sayfalar ekleyerek çocukların öğrenme deneyimini zenginleştirmelerine olanak tanır. Kullanıcılar, sayfalara görseller ekleyip sesli etiketler atayabilir ve bu etiketler QR kodlar ile erişilebilir hale getirilebilir.

## Özellikler

- **Kitap Oluşturma:** Eğitimciler yeni kitaplar oluşturabilir ve bu kitaplara sayfalar ekleyebilir.
- **Sayfa Ekleme:** Kitaplara görseller, metinler ve sesli anlatımlar eklenebilir.
- **Sesli Etiketleme:** Sayfalardaki görsellere sesli etiketler eklenebilir.
- **QR Kod Entegrasyonu:** Sayfalara QR kodlar eklenerek mobil uygulama üzerinden erişim sağlanabilir.
- **Kullanıcı Yönetimi:** Eğitimciler ve öğrenciler için kullanıcı hesapları oluşturulabilir ve yönetilebilir.
- **Rol Tabanlı Erişim Kontrolü:** Kullanıcılara admin, editor, viewer gibi roller atanabilir ve bu roller sayesinde sistemdeki farklı yetkilere sahip olabilirler.


## Kurulum

Projeyi yerel ortamınızda çalıştırmak için aşağıdaki adımları izleyin:

### Gereksinimler

- PHP 7.4 veya daha yeni bir sürüm
- Composer
- Laravel 8.x
- PostgreSQL

### Adımlar

1. **Depoyu klonlayın:**

    git clone https://github.com/kullanici_adiniz/dokunduuyogren.git
    cd dokunduuyogren


2. **Gerekli bağımlılıkları yükleyin:**

    composer install
    npm install
    npm run dev


3. **.env dosyasını yapılandırın:**
    `.env.example` dosyasını kopyalayarak `.env` dosyasını oluşturun ve gerekli veritabanı yapılandırmalarını yapın.

    cp .env.example .env
    php artisan key:generate


4. **Veritabanını oluşturun ve migrasyonları çalıştırın:**

    php artisan migrate
    php artisan db:seed


5. **Sunucuyu başlatın:**

    php artisan serve


6. **Tarayıcınızda projeyi açın:**
    `http://localhost:8000`

## Kullanım

### Admin Ekleme ve Rol Atama### 
    Proje, kullanıcılar için rol tabanlı yetkilendirme sağlar. Admin, editor ve viewer gibi roller sayesinde kullanıcıların,erişebilecekleri özellikler kontrol edilebilir. Yeni bir admin kullanıcı eklemek ve rol atamak için şu adımları izleyin:
    
- **Admin Rolü Oluşturma**
    php artisan tinker
    use Spatie\Permission\Models\Role;
    Role::create(['name' => 'admin']);

- **Yeni Bir Admin Kullanıcısı Oluşturma**
    use App\Models\User;
    $admin = User::create([
        'name' => 'Admin Name',
        'email' => 'admin@example.com',
        'password' => bcrypt('password123'), // Şifrenizi belirleyin
    ]);
    $admin->assignRole('admin');

- **Mevcut Bir Kullanıcıya Rol Atama**

    use App\Models\User;
    $user = User::find(1); // 1 yerine kullanıcı ID'sini girin
    $user->assignRole('admin'); // Kullanıcıya admin rolünü atayın


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



