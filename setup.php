<?php

use Symfony\Component\Translation\Translator;

use Symfony\Component\Security\Csrf\CsrfTokenManager;

use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Csrf\CsrfExtension;
use Symfony\Component\Form\Extension\Templating\TemplatingRendererEngine;

use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParserInterface;
use Symfony\Component\Templating\TemplateReference;

use Symfony\Bundle\FrameworkBundle\Templating\Helper\FormHelper;
use Symfony\Bundle\FrameworkBundle\Templating\Helper\TranslatorHelper;

$loader = require __DIR__ . '/../app/autoload.php';
$loader->register();

class StubTemplateNameParser implements TemplateNameParserInterface
{
  private $root;
  private $rootTheme;

  public function __construct($root, $rootTheme)
  {
    $this->root = $root;
    $this->rootTheme = $rootTheme;
  }

  public function parse($name)
  {
    list($bundle, $controller, $template) = explode(':', $name);
    $path = $this->root . '/' . $controller . '/' . $template;
    return new TemplateReference($path, 'php');
  }
}

$root = realpath(__DIR__ . '/../vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views');
$rootTheme = realpath(__DIR__ . '/../vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Resources');

$templateNameParser = new StubTemplateNameParser($root, $rootTheme);
$loader = new FilesystemLoader([]);
$phpEngine = new PhpEngine(new StubTemplateNameParser($root, $rootTheme), $loader);
$tempEngine = new TemplatingRendererEngine($phpEngine, ['FrameworkBundle:Form']);
$renderer = new FormRenderer($tempEngine);

$form_helper = new FormHelper($renderer);

$phpEngine->setHelpers(array(
  $form_helper,
  new TranslatorHelper(new Translator('ru')),
));

$csrfTokenManager = new CsrfTokenManager();
$formFactory = Forms::createFormFactoryBuilder()
  ->addExtension(new CsrfExtension($csrfTokenManager))
  ->getFormFactory();