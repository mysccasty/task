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
    public function __construct(object $record){
        $this->replacements=[
            "{{{first_name}}}"=>$record->get_first_name(),
            "{{{surname}}}"=>$record->get_surname(),
            "{{{place}}}"=>$record->get_place(),
            "{{{group}}}"=>$record->get_group(),
            "{{{mark}}}"=>$record->get_mark(),
            
        ];
    }
    public function render(){
        return str_replace(
            array_keys($this->replacements),
            array_values($this->replacements),
            self::LAYOUT);
    }
}