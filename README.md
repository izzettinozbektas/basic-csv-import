## CSV Import Case

 - Repoyu indir
 - Docker bilgisayarınızda olmalı
 - Proje dizininde  kurulum.sh (./kurulum.sh) çalıştır

> http://localhost:8001 den projeyi çalışır
> 
> http://localhost:8002 den phpmyadmin 
> 
 phpmyadmin giriş bilgileri 
   - sunucu `app-mysql`  # docker container name olmalı
   - kullanıcı adı `root`
   - parola `root` dev isimli db case indir


## Dockersız kullanım
 - Repoyu indir
 - Proje dizinindeki migration altındaki sql'i alıp oluşturmuş olduğunuz veritabanına import edin;
 - Confiq static classındaki bilgileri sql sunucu bilgileriniz ile güncelleyin;
 - `composer require "ext-gd:*" --ignore-platform-reqs` komutunu çalıştırın (yada composer install),
 - Proje dizinindeki site klasörünü kullanmış oldğunuz (php) localhosta atın,
 - işlem bittikten sonra localde projeyi çalıştırın.


####
Proje Hakkında
 - php(8.1)
 - composer
 - mysql8
 - docker

 basit bir csv import case dir, acılan pencerede csv formatında dosyaları veritabanına ekleyip kontrol edilmesi planlanmıştır.


### Not
 - kurulum.sh ile kurulum bittikten sonra migration çalışmaması yada connection refushed hatası durumunda
 Proje dizininde bu kodu çalıştırın `docker compose --profile tools run migrate`

