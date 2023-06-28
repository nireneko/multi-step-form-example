<?php

namespace Drupal\nekotuto\Wizard;

use Drupal\Core\Form\FormStateInterface;
use Drupal\ctools\Wizard\FormWizardBase;

class MultiStepForm extends FormWizardBase {

  public function getOperations($cached_values) {
    return [
      'one' => [
        'form' => 'Drupal\nekotuto\Form\StepOneForm',
        'title' => $this->t('Form One'),
        'submit' => ['::stepOneSubmit'],
      ],
      'two' => [
        'form' => 'Drupal\nekotuto\Form\StepTwoForm',
        'title' => $this->t('Form Two'),
        'submit' => ['::stepTwoSubmit'],
      ],
      'three' => [
        'form' => 'Drupal\nekotuto\Form\StepThreeForm',
        'title' => $this->t('Form Three'),
        'submit' => ['::stepThreeSubmit'],
      ],
    ];
  }

  /**
   * Submission callback for the first step.
   */
  public function stepOneSubmit($form, FormStateInterface $form_state) {
    $cached_values = $form_state->getTemporaryValue('wizard');
    $cached_values['one']['message'] = $form_state->getValue('message');
    $form_state->setTemporaryValue('wizard', $cached_values);
  }

  public function stepTwoSubmit($form, FormStateInterface $form_state) {
    $cached_values = $form_state->getTemporaryValue('wizard');
    $cached_values['two']['message'] = $form_state->getValue('message');
    $form_state->setTemporaryValue('wizard', $cached_values);
  }

  public function stepThreeSubmit($form, FormStateInterface $form_state) {
    $cached_values = $form_state->getTemporaryValue('wizard');
    $cached_values['three']['message'] = $form_state->getValue('message');
    $form_state->setTemporaryValue('wizard', $cached_values);
  }

  /**
   * {@inheritdoc}
   */
  public function getRouteName() {
    return 'nekotuto.wizard.form.step';
  }

  /**
   * {@inheritdoc}
   */
  public function finish(array &$form, FormStateInterface $form_state) {
    $cached_values = $form_state->getTemporaryValue('wizard');
    $this->messenger()->addMessage($this->t('Value One: @one', ['@one' => $cached_values['one']['message']]));
    $this->messenger()->addMessage($this->t('Value Two: @two', ['@two' => $cached_values['two']['message']]));
    $this->messenger()->addMessage($this->t('Value Three: @three', ['@three' => $cached_values['three']['message']]));
    $form_state->setRedirect('<front>');
    parent::finish($form, $form_state);
  }


}
