<?php
class View{
    const LAYOUT = <<<HTML
    <tr {{{marked}}}>
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
    public function render(array $students, ?array $marked=[]): string{
        $str = "";
        foreach($students as $key){
            $markOpen = "";
            $markClose = "";
            $this->replacements=["{{{marked}}}"=>"",
                "{{{first_name}}}"=>$key->get_first_name(),
                "{{{surname}}}"=>$key->get_surname(),
                "{{{place}}}"=>$key->get_place(),
                "{{{group}}}"=>$key->get_group_id(),
                "{{{mark}}}"=>$key->get_mark(),
                
            ];
            if (in_array($key->get_student_id(), $marked)){
                $this->replacements["{{{marked}}}"] = 'class="marked"';
            }
            $str .= str_replace(
                array_keys($this->replacements),
                array_values($this->replacements),
                self::LAYOUT
            );

        }

        return $str;
    }
}