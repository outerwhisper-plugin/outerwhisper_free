<?php

namespace OuterWhisper\Database\Entity;

class FormFeedbackAnswer {
    private $id;
    private $feedback_id;
    private $form_id;
    private $field_id;
    private $field_type;
    private $num_value;
    private $text_value;
    private $created;

    public function __construct($data = []) {
        if (!empty($data)) {
            $this->id          = isset($data['outerwhisper_ffa_id']) ? (int) $data['outerwhisper_ffa_id'] : null;
            $this->feedback_id = isset($data['outerwhisper_ffa_ff_id']) ? (int) $data['outerwhisper_ffa_ff_id'] : null;
            $this->form_id     = isset($data['outerwhisper_ffa_fd_id']) ? (int) $data['outerwhisper_ffa_fd_id'] : null;
            $this->field_id    = $data['outerwhisper_ffa_field_id'] ?? '';
            $this->field_type  = $data['outerwhisper_ffa_field_type'] ?? '';
            $this->num_value   = isset($data['outerwhisper_ffa_num_value']) ? (float) $data['outerwhisper_ffa_num_value'] : null;
            $this->text_value  = $data['outerwhisper_ffa_text_value'] ?? null;
            $this->created     = $data['outerwhisper_ffa_created'] ?? '';
        }
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getFeedbackId(): ?int {
        return $this->feedback_id;
    }

    public function getFormId(): ?int {
        return $this->form_id;
    }

    public function getFieldId(): string {
        return $this->field_id;
    }

    public function getFieldType(): string {
        return $this->field_type;
    }

    public function getNumValue(): ?float {
        return $this->num_value;
    }

    public function getTextValue(): ?string {
        return $this->text_value;
    }

    public function getCreated(): string {
        return $this->created;
    }

    public function toArray(array $ignore = []): array {
        $fields = [
            'id'          => $this->id,
            'feedback_id' => $this->feedback_id,
            'form_id'     => $this->form_id,
            'field_id'    => $this->field_id,
            'field_type'  => $this->field_type,
            'num_value'   => $this->num_value,
            'text_value'  => $this->text_value,
            'created'     => $this->created,
        ];

        if (!empty($ignore)) {
            foreach ($ignore as $field_name) {
                if (array_key_exists($field_name, $fields)) {
                    unset($fields[$field_name]);
                }
            }
        }

        return $fields;
    }
}
