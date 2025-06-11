# AI.md

Bu projedeki fikir, konu seçimi, veritabanı yapısı ve uygulamanın genel tasarımı tamamen bana aittir. Hayvanat bahçesi hayvan takip sistemi fikrini kendim belirledim ve veritabanı şemasını, sayfa yapılarını, grafik mantığını kendim planladım.

Projenin geliştirme sürecinde PHP ve MySQL tarafında temel kodlamaları doğrudan kendim yazdım. Frontend kısmında ise Bootstrap kütüphanesini kullandım ve bazı stiller için kendi CSS kodlarımı oluşturdum.

Sadece aşağıdaki bazı teknik konularda **ChatGPT**’den destek aldım:

---

## 1. Hosting’e proje yükleme süreci

**Ben:** Üniversitenin verdiği FTP ve phpMyAdmin erişim bilgilerini kullanarak projeyi nasıl yüklerim? Dosyaları nereye koymam gerekir?

**ChatGPT:** FileZilla ile `public_html` dizinine index.php dahil tüm dosyaları yüklemeniz gerekiyor. Ayrıca veritabanını phpMyAdmin üzerinden içe aktarmanız ve db.php dosyasındaki bağlantı bilgilerini güncellemeniz gerekmektedir...

---

## 2. Hostingde çalışırken 403 hatası

**Ben:** Projemi sunucuya yükledim ama "403 Forbidden" hatası alıyorum. Neden olabilir?

**ChatGPT:** Bu hata genellikle index.php dosyasının olmaması, yanlış yere yüklenmesi veya dosya izinlerinin hatalı olması nedeniyle oluşur. Dosyaların `public_html` dizininin içinde olduğundan emin olun...

---

## 3. Chart.js grafiklerinin boyut ayarları

**Ben:** Dashboard’da çizdiğim grafikler çok büyük çıkıyor. Responsive ve küçük boyutlu nasıl yapabilirim?

**ChatGPT:** height değerini kaldırarak `aspectRatio` kullanabilir ve CSS ile `max-width` tanımlayabilirsiniz...

---

Ayrıca görsel olarak ilham almak ve genel tasarımı daha güzel hale getirmek için bazı arayüz fikirlerini YouTube’daki web development projelerinden esinlendim. Fakat kodların tamamı bana ait olup, sadece bazı çözüm yollarını referans alarak uygulamaya uyarladım.

---

Bu proje sürecinde, yapay zeka sadece danışmanlık ve yönlendirme amacıyla kullanılmıştır. Karar verme, kodlama ve proje yönetimi tamamen bana aittir.
