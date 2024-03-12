<?php

class AdbTranslationController extends BaseController {

    public function translationsUpdateAction() {
        $callbacks = [];
        $edits = $this->request->getPost('translation');
        $module = $this->getPost('module');
        $group_slug = $this->getPost('group_slug');
        $key = $this->getPost('key');
        $errors = [];
        foreach ($edits as $language => $value) {
            $availableLanguageTranslations = Translations::availableLanguagesTranslations();
            errorIf(!isset($availableLanguageTranslations[$language]), 'Invalid language code');
            $model = Translations::findFirst([
                "conditions" => "language = :language: AND module = :module: AND group_slug = :group_slug: AND key = :key:",
                "bind" => [
                    "language" => $language,
                    "module" => $module,
                    "group_slug" => $group_slug,
                    "key" => $key
                ]
            ]);
            if (!$model) {
                $value = trim($value);
                if ($value !== '') {
                    $model = new Translations();
                    $model->module = $this->getPost('module');
                    $model->group_slug = $this->getPost('group_slug');
                    $model->key = $this->getPost('key');
                    $model->language = $language;
                } else {
                    continue;
                }
            }
            $model->value =  strip_tags($value, Translations::ALLOWED_TAGS_TRANSLATIONS);
            try {
                $model->saveOrFail();
            } catch (\Throwable $exception) {
                $errors[] = "Error while saving ($language):  " . $exception->getMessage();
            }
        }
        if (empty($errors)) {
            $callbacks[] = new ResponseCallbacks\LocationHashChanged();
            $callbacks[] = new ResponseCallbacks\FlashMessage('Saved');
        } else {
            $callbacks[] = new ResponseCallbacks\LocationHashChanged();
            foreach ($errors as $error) {
                $callbacks[] = new ResponseCallbacks\FlashMessage("error: $error", true);
            }
        }
        $this->respond(['callbacks' => $callbacks]);
    }

    public function onlineTranslationsAction () {
        $callbacks = [];
        $errors = [];
        $originalLanguage = $this->getPost('translate');
        $edits = $this->request->getPost('translation');
        $trans = new \GoogleTranslate();
        $availableLanguageTranslations = Translations::availableLanguagesTranslations();
        foreach ($edits as $language => $text) {
            errorIf(!isset($availableLanguageTranslations[$language]), 'Invalid language code');
            if ($text == '') {
                $source = $this->_getGoogleLangCode($originalLanguage);
                $target = $this->_getGoogleLangCode($language);
                $text = $edits[$originalLanguage];
                try {
                    $translatedText = $trans->translate($source, $target, $text);
                    $callbacks[] = new ResponseCallbacks\SetProperty('textarea[name="translation[' . $language . ']"]', 'value', $translatedText);
                } catch (\Throwable $exception) {
                    $errors[] = "Error while saving ($language):  " . $exception->getMessage();
                }
            }
        }
        if ($errors) {
            foreach ($errors as $error) {
                $callbacks[] = new ResponseCallbacks\FlashMessage("error: $error", true);
            }
        }
        $this->respond(['callbacks' => $callbacks]);
    }
}
