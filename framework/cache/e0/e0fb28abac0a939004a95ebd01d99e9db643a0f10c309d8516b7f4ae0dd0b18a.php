<?php

/* new.html */
class __TwigTemplate_84cc9b081cf67dc1dd2af2e8af3ba9873481acc30e2f7934b53aff41e36feb3c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<h1>Привет из файло шаблонизатора 2!</h1>
<ul>
    <li>ggh</li>
</ul>

";
    }

    public function getTemplateName()
    {
        return "new.html";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "new.html", "C:\\OpenServer\\domains\\test\\graduate_work_php\\templates\\new.html");
    }
}
