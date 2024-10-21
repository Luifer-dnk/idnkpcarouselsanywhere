<?php
/**
 *  Copyright (C) Idnk Soft - All Rights Reserved.
 *
 *  This is proprietary software therefore it cannot be distributed or reselled.
 *  Unauthorized copying of this file, via any medium is strictly prohibited.
 *  Proprietary and confidential.
 *
 * @author    Idnk Soft <contact@idnk-soft.fr>
 * @copyright 2007.
 * @license   Commercial license
 */

$sql = array();
// Delete customer validation table
$sql[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "idnk_carousel`";
$sql[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "idnk_carousel_lang`";
$sql[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "idnk_carousel_category_association`";
foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
