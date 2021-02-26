<?php


namespace app\core\html;


class FormField
{
    private string $id;
    private string $name;
    private string $class;
    private string $labelName;
    private string $param;

    /**
     * FormField constructor.
     * @param string $id
     * @param string $name
     * @param string $class
     * @param string $labelName
     * @param string $param
     */
    public function __construct(string $id, string $name, string $class, string $labelName, string $param)
    {
        $this->id = $id;
        $this->name = $name;
        $this->class = $class;
        $this->labelName = $labelName;
        $this->param = $param;
    }


    public function __toString()
    {
        // TODO: Implement __toString() method.
        ob_start();
        ?>
        <div class="form-group">
            <label for="email">Email:<sup>*</sup></label>
            <input type="text" name="email" id="email" class=" form-control form-control-lg" value="">
            <span class='invalid-feedback'></span>
        </div>
<?php
        return ob_get_clean();

    }

}