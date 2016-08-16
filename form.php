<?php

include "setup.php";

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

$form = $formFactory->createNamedBuilder('mirtrik-registration', FormType::class, null, [
  'action' => 'post.php'
])
  ->add('is_retail', CheckboxType::class, ['required' => FALSE])
  ->add('email', TextType::class)
  ->add('fullname', TextType::class)
  ->add('pass1', PasswordType::class)
  ->add('pass2', PasswordType::class)
  ->add('destination', HiddenType::class, ['data' => "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"])
  ->add('submit', SubmitType::class)
  ->getForm();

$form_view = $form->createView();

header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
  <head>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>
  <body>
    <?php print $form_helper->start($form_view) ?>
    <?php print $form_helper->widget($form_view) ?>
    <div class="g-recaptcha" data-sitekey="6LepqCcTAAAAAL97mElI5ydBI8_NBUwf2n0GMRm3"></div>
    <?php print $form_helper->end($form_view) ?>
  </body>
</html>
