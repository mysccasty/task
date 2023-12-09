<?php
class Viewer{
    const LAYOUT = <<<HTML
    <tr>
        <td>
            {{{first_name}}}
        </td>
        <td>
            {{{surname}}}
        </td>
        <td>
            {{{place}}}
        </td>
        <td>
            {{{group}}}
        </td>
        <td>
            {{{mark}}}
        </td>
    </tr>
    HTML;
    protected $replacements;
    public function __construct(){
    }
    public function render(array $students): string{
        $str = "";
        foreach($students as $key){
            $this->replacements=[
                "{{{first_name}}}"=>$key->get_first_name(),
                "{{{surname}}}"=>$key->get_surname(),
                "{{{place}}}"=>$key->get_place(),
                "{{{group}}}"=>$key->get_group_id(),
                "{{{mark}}}"=>$key->get_mark(),
                
            ];
            $str .= str_replace(
                array_keys($this->replacements),
                array_values($this->replacements),
                self::LAYOUT
            );

        }

        return $str;
    }
}