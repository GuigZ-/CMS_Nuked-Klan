<?php
/**
 * @version     1.7.10
 * @link http://www.nuked-klan.org Clan Management System for Gamers
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright 2001-2015 Nuked-Klan (Registred Trademark)
 */
defined('INDEX_CHECK') or die ('You can\'t run this file alone.');

function affich_block_theme($blok){
    global $cookie_theme;

    $blok['content'] .= '<form method="post" action="index.php?file=User&amp;nuked_nude=index&amp;op=modif_theme">'."\n"
    . '<div style="text-align: center"><select name="user_theme" onchange="submit();">'."\n"
    . '<option value="">' . _BTHEMESELECT . '</option>'."\n";

    $handle = @opendir('themes');
    while (false !== ($f = readdir($handle))){
        if ($f != '.' && $f != '..' && $f != 'CVS' && $f != 'index.html' && !preg_match('`[.]`', $f)){

            if ($cookie_theme == $f) $checked = 'selected="selected"';
            else $checked = '';

            $blok['content'] .= '<option value="' . $f . '" ' . $checked . '>' . $f . '</option>';
        }
    }
    closedir($handle);

    $blok['content'] .= '</select></div></form>'."\n";

    return $blok;
}

function edit_block_theme($bid){
    global $nuked, $language;

    $sql = mysql_query('SELECT active, position, titre, module, content, type, nivo, page FROM ' . BLOCK_TABLE . ' WHERE bid = \'' . $bid . '\' ');
    list($active, $position, $titre, $modul, $content, $type, $nivo, $pages) = mysql_fetch_array($sql);
    $titre = printSecuTags($titre);

    if ($active == 1) $checked1 = 'selected="selected"';
    else if ($active == 2) $checked2 = 'selected="selected"';
    else $checked0 = 'selected="selected"';

    echo '<div class="content-box">',"\n" //<!-- Start Content Box -->
			, '<div class="content-box-header"><h3>' , _BLOCKADMIN , '</h3>',"\n"
			, '<div style="text-align:right;"><a href="help/' , $language , '/block.html" rel="modal">',"\n"
			, '<img style="border: 0;" src="help/help.gif" alt="" title="' , _HELP , '" /></a>',"\n"
			, '</div></div>',"\n"
			, '<div class="tab-content" id="tab2"><form method="post" action="index.php?file=Admin&amp;page=block&amp;op=modif_block">',"\n"
			, '<table style="margin-left: auto;margin-right: auto;text-align: left;" cellspacing="0" cellpadding="2" border="0">',"\n"
			, '<tr><td><b>' , _TITLE , '</b></td><td><b>' , _BLOCK , '</b></td><td><b>' , _POSITION , '</b></td><td><b>' , _LEVEL , '</b></td></tr>',"\n"
			, '<tr><td><input type="text" name="titre" size="40" value="' , $titre , '" /></td>',"\n"
			, '<td><select name="active">',"\n"
			, '<option value="1" ' , $checked1 , '>' , _LEFT , '</option>',"\n"
			, '<option value="2" ' , $checked2 , '>' , _RIGHT , '</option>',"\n"
			, '<option value="0" ' , $checked0 , '>' , _OFF , '</option></select></td>',"\n"
			, '<td><input type="text" name="position" size="2" value="' , $position , '" /></td>',"\n"
			, '<td><select name="nivo"><option>' , $nivo , '</option>',"\n"
			, '<option>0</option>',"\n"
			, '<option>1</option>',"\n"
			, '<option>2</option>',"\n"
			, '<option>3</option>',"\n"
			, '<option>4</option>',"\n"
			, '<option>5</option>',"\n"
			, '<option>6</option>',"\n"
			, '<option>7</option>',"\n"
			, '<option>8</option>',"\n"
			, '<option>9</option></select></td></tr><tr><td colspan="4">&nbsp;</td></tr>',"\n"
			, '<tr><td colspan="4"><b>' , _PAGESELECT , ' :</b></td></tr><tr><td colspan="4">&nbsp;</td></tr>',"\n"
			, '<tr><td colspan="4"><select name="pages[]" size="8" multiple="multiple">',"\n";

    select_mod2($pages);

    echo '</select></td></tr><tr><td colspan="4" align="center"><br />',"\n"
			, '<input type="hidden" name="type" value="' , $type , '" />',"\n"
			, '<input type="hidden" name="bid" value="' , $bid , '" />',"\n"
			, '</td></tr></table>',"\n"
			, '<div style="text-align: center;"><br /><input class="button" type="submit" name="send" value="' , _MODIFBLOCK , '" /><a class="buttonLink" href="index.php?file=Admin&amp;page=block">' , _BACK , '</a></div></form><br /></div></div>',"\n";
	
}
?>