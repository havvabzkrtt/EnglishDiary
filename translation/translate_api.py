# translate_api.py
from flask import Flask, request, jsonify
import argostranslate.package
import argostranslate.translate
import os

app = Flask(__name__)

# Model klasörü
model_dir = os.path.dirname(os.path.abspath(__file__))

# .argosmodel dosyalarını yükle
for filename in os.listdir(model_dir):
    if filename.endswith('.argosmodel'):
        argostranslate.package.install_from_path(os.path.join(model_dir, filename))

@app.route('/translate', methods=['POST'])
def translate_text():
    data = request.get_json()
    text = data['text']
    from_lang = data['from']
    to_lang = data['to']

    installed_languages = argostranslate.translate.get_installed_languages()

    try:
        from_lang_obj = next(x for x in installed_languages if x.code == from_lang)
        to_lang_obj = next(x for x in installed_languages if x.code == to_lang)
    except StopIteration:
        return jsonify({'error': 'Language not supported'}), 400

    translation = from_lang_obj.get_translation(to_lang_obj)
    translated_text = translation.translate(text)

    return jsonify({'translated_text': translated_text})

if __name__ == '__main__':
    app.run(port=5000)
