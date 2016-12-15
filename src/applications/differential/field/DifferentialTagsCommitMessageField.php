<?php

final class DifferentialTagsCommitMessageField
  extends DifferentialCommitMessageField {

  const FIELDKEY = 'phabricator:projects';

  public function getFieldName() {
    return pht('Tags');
  }

  public function getFieldOrder() {
    return 7000;
  }

  public function getFieldAliases() {
    return array(
      'Tag',
      'Project',
      'Projects',
    );
  }

  public function isTemplateField() {
    return false;
  }

  public function parseFieldValue($value) {
    return $this->parseObjectList(
      $value,
      array(
        PhabricatorProjectProjectPHIDType::TYPECONST,
      ));
  }

  public function readFieldValueFromObject(DifferentialRevision $revision) {
    if (!$revision->getPHID()) {
      return array();
    }

    $projects = PhabricatorEdgeQuery::loadDestinationPHIDs(
      $revision->getPHID(),
      PhabricatorProjectObjectHasProjectEdgeType::EDGECONST);
    $projects = array_reverse($projects);

    return $projects;
  }

  public function readFieldValueFromConduit($value) {
    return $this->readStringListFieldValueFromConduit($value);
  }

  public function renderFieldValue($value) {
    return $this->renderHandleList($value);
  }


}
