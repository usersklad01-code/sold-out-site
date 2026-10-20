<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

if(empty($arResult))
    return "";

$strReturn = '';
$itemSize = count($arResult);


if($itemSize!=1) {
    $strReturn .= '<div class="container"><div class="breadcrumbs"><ul class="breadcrumbs__list" itemscope itemtype="http://schema.org/BreadcrumbList">';

    for ($index = 0; $index < $itemSize; $index++) {
        $title = htmlspecialcharsex($arResult[$index]["TITLE"]);

        $nextRef = ($index < $itemSize - 2 && $arResult[$index + 1]["LINK"] <> "" ? ' itemref="bx_breadcrumb_' . ($index + 1) . '"' : '');
        $child = ($index > 0 ? ' itemprop="child"' : '');
        $arrow = ($index > 0 ? '' : '');

        if ($index < $itemSize - 1) {
            $strReturn .= '<li class="breadcrumbs__link-after" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                            <a class="breadcrumbs__link" itemprop="item" href="' . $arResult[$index]["LINK"] . '" title="' . $title . '">
                                <span itemprop="name">' . $title . '</span>
                            </a>
                            <meta itemprop="position" content="' . ($index + 1) . '">
                        </li>';
        } else {
            $strReturn .= '<li class="breadcrumbs__link-after" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                            <span class="breadcrumbs__link" itemprop="item"><span itemprop="name">' . $title . '</span>
                            </span><meta itemprop="position" content="' . ($index + 1) . '">
                        </li>';
        }
    }

    $strReturn .= '</ul></div></div>';
}
return $strReturn;