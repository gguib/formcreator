<?php
class PluginFormcreatorHostnameField extends PluginFormcreatorField
{
   public function isPrerequisites() {
      return true;
   }

   public function getDesignSpecializationField() {
      $additions = '';

      return [
         'label' => '',
         'field' => '',
         'additions' => $additions,
         'may_be_empty' => false,
         'may_be_required' => false,
      ];
   }

   public function prepareQuestionInputForSave($input) {
      return $input;
   }

   public function show($canEdit = true) {
      if (!$canEdit) {
         return parent::show($canEdit);
      }

      $id           = $this->question->getID();
      $rand         = mt_rand();
      $fieldName    = 'formcreator_field_' . $id;
      $domId        = $fieldName . '_' . $rand;
      $hostname = gethostbyaddr(Toolbox::getRemoteIpAddress());
      $hostname = Html::cleanInputText($hostname);
      return Html::hidden($fieldName, [
         'id'    => $domId,
         'value' => $hostname
      ]);
   }

   public function serializeValue() {
      return $this->value;
   }

   public function deserializeValue($value) {
      $this->value = $value;
   }

   public function getValueForDesign() {
      return '';
   }

   public function getValueForTargetText($richText) {
      return Toolbox::addslashes_deep($this->value);
   }

   public function getDocumentsForTarget() {
      return [];
   }

   public function isValid() {
      return true;
   }

   public function isValidValue($value) {
      return true;
   }

   public static function getName() {
      return _n('Hostname', 'Hostname', 1);
   }

   public static function canRequire() {
      return false;
   }

   public function parseAnswerValues($input, $nonDestructive = false) {
      $key = 'formcreator_field_' . $this->question->getID();
      if (!is_string($input[$key])) {
         return false;
      }

      $this->value = $input[$key];
      return true;
   }

   public function equals($value) {
      return $this->value == $value;
   }

   public function notEquals($value) {
      return !$this->equals($value);
   }

   public function greaterThan($value) {
      return $this->value > $value;
   }

   public function lessThan($value) {
      return !$this->greaterThan($value) && !$this->equals($value);
   }

   public function isAnonymousFormCompatible() {
      return true;
   }

   public function getHtmlIcon() {
      return '<i class="fa fa-desktop" aria-hidden="true"></i>';
   }

   public function isVisibleField()
   {
      return false;
   }

   public function isEditableField()
   {
      return false;
   }
}
