# Kurulum ve Başlangıç Rehberi

## 1. Bağımlılıkların Kurulumu

```
composer install
```

## 2. Ortam Dosyası Oluşturma

```
cp .env.example .env
```

## 3. Uygulama Anahtarı Oluşturma

```
php artisan key:generate
```

## 4. Veritabanı Tablolarının yüklenmesi

```
php artisan migrate
```

## 5. Rol ve İzinlerin Yüklenmesi

Sistemde kullanılacak rol ve izinleri yüklemek için aşağıdaki komutu çalıştırmalısınız.  
**⚠️ Bu adımı atlamanız durumunda hata alırsınız.**

```
php artisan role-permission:import
```

## 6. Fake verilerin içeri aktarılması  
```
php artisan db:seed
```
---

## 7. Socket (Reverb) Testi

### Bağımlılıkların Kurulması

```
npm install
```

### Yapının Derlenmesi

```
npm run build
```

### Geliştirme Ortamında Çalıştırma

```
npm run dev
```

### Reverb Başlatma

```
php artisan reverb:start
```

> Socket testini gerçekleştirmek için `TestNotificationListener.vue` dosyasındaki ilgili alanlara `Postman` üzerinden giriş yaptıktan sonra `id` ve `token` değerlerini string olarak yapıştırabilirsiniz.

---

## 8. Yönetici Kullanıcı Bilgileri

```
email: admin@blog.com  
password: password  
login_type: 1 // email
```

---

## 9. Görev Zamanlayıcısını Çalıştırmak

```
php artisan schedule:work
```

---

## 10. Postman Dokümantasyonu

`docs/postman` klasörü içerisinde örnek `Postman` isteklerini içeren JSON dosyaları bulunmaktadır.

---

## 11. Kuyrukları ve Bildirimleri Dinlemek

```
php artisan queue:work
```

---

# Proje Mimarisi Hakkında

- Projede **OOP (Nesne Yönelimli Programlama)** standartlarına ve **SOLID presinplerine** uygun geliştirme yapılmıştır.
- **Soyutlamalar**, `Contracts` klasörü altında tanımlanarak bağımlılıklar esnek şekilde projeye enjekte edilmiştir.
- Laravel’in sunduğu olanaklar doğrultusunda `Repository` yerine doğrudan `Model` sınıfları üzerinden veri işlemleri gerçekleştirilmiş, **iş mantığı servis katmanına** taşınmıştır.

## Generic Service Yapısı

```php
/**
 * @extends ServiceInterface<Post, PostDTO, PostUpdateDTO, PostListDTO>
 */
```

- Bu sayede **tip güvenliği** sağlanmış ve **IDE desteği** artırılmıştır.
- `BaseService` üzerinden tüm ortak servis davranışları soyutlanmış; `CategoryService` gibi özel servisler hem `BaseService`'ten kalıtılarak hem de kendi `Interface`’leri implement edilerek yapılandırılmıştır.
- Model, servis içerisine constructor’da enjekte edilerek yeniden kod yazma ihtiyacı ortadan kaldırılmıştır.

## DTO (Data Transfer Object) Kullanımı

- Gelen veriler `DTO`’lara çevrilerek tip güvenliği sağlanır.
- `BaseDTO`, `BaseEnum`, `BaseValueObjectData` gibi sınıflarla ortak davranışlar soyutlanır.
- `Trait` ve `Abstract` sınıflar yardımıyla tekrar eden kod yazımı minimize edilir, **SOLID prensiplerine uygun** geliştirme yapılır.

## Hata Yönetimi

- `Exceptions` altında özel exception sınıfları ve handler yer alır.
- Özel hata sınıfları ile dış dünyaya anlamlı mesajlar dönülür.

## BaseModel Kullanımı

- Ortak `trait` ve method'lar `BaseModel` üzerinden yönetilir.
- Örneğin `HasUuid` trait’i sayesinde tüm modeller UUID kullanır.

## Observer ve Rule Kullanımı

- Laravel observer’ları ile model aksiyonları öncesi/sonrası işlemler yapılabilir.
- `Rules` klasöründe özel validation kuralları tanımlanabilir.

## Bildirim Sistemi

- `Notifications/SendCommentNotification` sınıfı ile aynı anda **mail**, **veritabanı** ve **broadcast (socket)** üzerinden bildirim gönderilir.

## Servis Sağlayıcılar (Providers)

- Arayüzlerin ilgili sınıflara bağlanması `AppServiceProvider` `ServiceServiceProvider` gibi servis sağlayıcılar üzerinden yapılır.

## Trait Kullanımı

- Ortak davranışlar trait olarak tanımlanıp modellerde tekrar tekrar kullanılabilir hale getirilmiştir.

## Route Yönetimi

- `routes/api/v1/` altına route dosyaları parçalanarak eklenir.
- `api.php` dosyasından bu parçalar dahil edilerek daha okunabilir ve yönetilebilir bir yapı kurulmuştur.

## Request Sınıfı Kullanımı

- Gelen veriler `Request` sınıflarında `toDto()` methodu ile DTO’ya çevrilir.
- Controller’ların tek görevi veriyi alıp ilgili servise iletmek ve yetkilendirme yapmaktır.

## Yetki ve İzin Yönetimi

- `config/roles.php` dosyasında roller ve izinler tanımlanmıştır.
- `RolePermissionImportCommand` ile izinler otomatik import edilir ve sade bir yapı sağlanır.

---

## Genel Bilgilendirme

Bu yapı sayesinde;

- Kod tekrarından kaçınılır,
- SOLID prensiplerine uygun bir yapı oluşturulur,
- Esnek, test edilebilir ve sürdürülebilir bir proje altyapısı sağlanmış olur.

> Sorularınız olursa çekinmeden iletebilirsiniz.
