<?php
namespace App\Classes;

use App\Models\Revision;
use App\Models\Content;
use Auth;
class Helper
{
    public static function makerevision($obj){
        if($obj->isDirty()){
            foreach(array_keys($obj->getDirty()) as $key => $value){
                if (!is_null($obj->getDirty()[$value])) {
                    $form['table_name'] = $obj->getTable();
                    $form['column_name'] = $value;
                    $form['ref_id'] = $obj->id;
                    $form['user_id'] = Auth::user()->id;
                    $form['old'] = $obj->getOriginal($value);
                    $form['new'] = $obj->getDirty()[$value];
                    Revision::create($form);
                }
            }
        }
    }
    public static function metadescription($obj, $limit = 300){
        $wstep = $obj->fulltext;
        $start = strpos($wstep, '<p>');
        $end = strpos($wstep, '</p>', $start);
        $lead = substr($wstep, $start, $end - $start + 4);
        $lead = str_replace('<p>', '', $lead);
        $lead = str_replace('</p>', '', $lead);
        $description = substr($lead, 0, $limit);
        $length = max([
            strrpos($description, '.', -1),
            strrpos($description, '?', -1),
            strrpos($description, '!', -1)
        ]);
        $description = substr($lead, 0, $length + 1);
        $descriptionn = strip_tags($description);
        $desc = str_replace('&quot;', '"', $descriptionn);
        return $desc;
    }
    public static function tnij($obj, $limit){
        $text = strip_tags($obj->fulltext);
        $eksplode = explode(" ", $text);
        $policz = count($eksplode);
        if ($policz > $limit) {
            $text = $eksplode[0];
            for ($i = 1; $i < $limit; $i++) {
                $text .= " " . $eksplode[$i];
            }
            return $text;
        } else {
            return $text;
        }
    }


    public static function propozycjaText($obj)
    {
        $result = "";
        $text = strip_tags($obj->fulltext);
        $text = explode("\r\n", $text);
        $nowytext = array();
        foreach ($text as $key => $value) {
            if ($value == "") {
                continue;
            } else {
                $nowytext[] = $value;
            }
        }
        for ($i = 0; $i < 4; $i++) {
            $result .= '<p class="akapit' . $i . '">' . $nowytext[$i] . '</p>';
        }
        return $result;
        // dd($nowytext,$obj->fulltext);
        // $eksplode = explode(" ", $text);
        // $policz = count($eksplode);
        // if ($policz > $limit) {
        // $text = $eksplode[0];
        // for ($i = 1; $i < $limit; $i++) {
        // $text .= " " . $eksplode[$i];
        // }
        // return $text;
        // } else {
        // return $text;
        // }
    }

    public static function zdjecianowerss($obj){
        $img = $obj->image->sortByDesc('created_at')->groupBy('type')->toArray();
        if (count($img) > 0) {
            $pathDesktop = $img['desktop'][0]['path'];

        } else {
            $pathDesktop = 'storage/images/article/default/Grafika-SR.jpg';

        }
        return $pathDesktop;
    }

    public static function hits($obj) {
        $art = Content::findOrFail($obj->id);
        ++$art->hits;
        $art->save();
        setcookie($obj->id, $obj->id);

    }
}
