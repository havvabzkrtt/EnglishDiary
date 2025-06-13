

# 🧠 Translation Modülü Hakkında - Çeviri Uygulaması (TR ⇄ EN)

Bu proje, PHP arayüzü üzerinden Flask API ile İngilizce ⇄ Türkçe kelime çevirisi yapar.

## 📁 Klasör Yapısı

```

EnglishDiary/
├── translation/
│   ├── translation.php       # PHP arayüzü
│   ├── app.py                # Flask API
│   ├── model\_en\_tr/          # EN → TR modeli
│   └── model\_tr\_en/          # TR → EN modeli
├── include/
├── assets/

```

Bu klasörde iki ana dosya bulunmaktadır:

- `translate_api.py`: Python tabanlı çeviri API servisidir.
- `translate.php`: PHP tarafında, Python API'ye istek gönderip çeviri sonucunu alan dosyadır.

## Çalışma Prensibi

1. **translate_api.py**
   - Flask ile çalışan bir web API servisidir.
   - Argos Translate kütüphanesini kullanır.
   - HTTP POST ile gelen metni, belirtilen diller arasında çevirir ve sonucu JSON olarak döner.

2. **translate.php**
   - PHP ile yazılmıştır.
   - Kullanıcıdan alınan metni ve dil parametrelerini, `translate_api.py`'nin çalıştığı sunucuya HTTP isteğiyle gönderir.
   - Dönen çeviri sonucunu kullanıcıya gösterir.

## Model Dosyaları

Çeviri işleminin çalışabilmesi için Argos Translate model dosyalarını indirmeniz gerekmektedir. Model dosyalarını aşağıdaki adresten indirip, Argos Translate'in kullandığı dizine ekleyiniz:

[https://www.argosopentech.com/argospm/index/](https://www.argosopentech.com/argospm/index/)

## Notlar

- Python API servisini başlatmadan önce gerekli kütüphaneleri yükleyin (`pip install flask, argostranslate`).
- PHP dosyasının çalışabilmesi için Python API'nın arka planda çalışıyor olması

