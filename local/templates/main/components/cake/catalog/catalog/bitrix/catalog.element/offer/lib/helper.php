<?php
/** *************************************************************************
 * Хелпер для шаблона деталки
 * **************************************************************************/
namespace DJ\Helpers;

class CatalogDetail
{
	/** *************************************************************************
	 * Подготовить список изображений
	 * @param array $item
	 * @return array
	 * **************************************************************************/
	public static function preparePictureList(array $item): array {
		$arPictures = [];

		// детальная картинка
		if (!empty($item["DETAIL_PICTURE"])) {
			$arPictures[] = $item["DETAIL_PICTURE"];
		}

		// дополнительные картинки
		foreach ($item['PROPERTIES']['PICTURES']['VALUE'] as $id){
			$arPictures[] = \CFile::GetFileArray($id);
		}

		// если картинок нет - пробуем взять хотябы preview
		if (count($arPictures) === 0 && !empty($item["PREVIEW_PICTURE"])) {
			$arPictures[] = $item["PREVIEW_PICTURE"];
		}

		// если картинок вообще никаких нет - картинка по умолчанию
		if (count($arPictures) === 0) {
			$arPictures[] = array("SRC" => SITE_TEMPLATE_PATH . "/tpl/assets/img/no-photo.svg");
		}

		// результат
		return $arPictures;
	}

}