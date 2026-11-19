<?php

namespace OuterWhisper\Database;

use OuterWhisper\Database\Database;
use OuterWhisper\Database\Entity\FormFeedbackAnswer as FormFeedbackAnswerEntity;

class FormFeedbackAnswer extends Database {
    public function __construct() {
        parent::__construct();
        $this->table_name = $this->wpdb->prefix . 'outerwhisper_form_feedback_answers';
    }

    public function create_table() {
        $charset_collate = $this->wpdb->get_charset_collate();

        $sql = "CREATE TABLE $this->table_name (
            outerwhisper_ffa_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            outerwhisper_ffa_ff_id INT(11) UNSIGNED NOT NULL,
            outerwhisper_ffa_fd_id INT(11) UNSIGNED NOT NULL,
            outerwhisper_ffa_field_id VARCHAR(64) NOT NULL,
            outerwhisper_ffa_field_type VARCHAR(32) NOT NULL,
            outerwhisper_ffa_num_value FLOAT NULL DEFAULT NULL,
            outerwhisper_ffa_text_value TEXT NULL DEFAULT NULL,
            outerwhisper_ffa_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
            PRIMARY KEY (outerwhisper_ffa_id),
            INDEX outerwhisper_ffa_ff_id (outerwhisper_ffa_ff_id),
            INDEX outerwhisper_ffa_fd_id (outerwhisper_ffa_fd_id),
            INDEX outerwhisper_ffa_field_type (outerwhisper_ffa_field_type),
            INDEX outerwhisper_ffa_created (outerwhisper_ffa_created),
            INDEX idx_ffa_type_num_created (outerwhisper_ffa_field_type, outerwhisper_ffa_num_value, outerwhisper_ffa_created),
            INDEX idx_ffa_fd_type_num_created (outerwhisper_ffa_fd_id, outerwhisper_ffa_field_type, outerwhisper_ffa_num_value, outerwhisper_ffa_created)
        ) $charset_collate ENGINE=InnoDB;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        $this->add_foreign_keys();
    }

    private function add_foreign_keys() {
        $wpdb = $this->wpdb;
        $feedback_table = $wpdb->prefix . 'outerwhisper_form_feedback';
        $form_table     = $wpdb->prefix . 'outerwhisper_form_data';

        // Foreign Key to FormFeedback
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery -- Checking a foreign key constraint for a custom plugin table.
        $check_fk_ff = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT CONSTRAINT_NAME
                 FROM information_schema.KEY_COLUMN_USAGE
                 WHERE TABLE_SCHEMA = DATABASE()
                   AND TABLE_NAME = %s
                   AND CONSTRAINT_NAME = %s
                   AND REFERENCED_TABLE_NAME IS NOT NULL",
                $this->table_name,
                'FK_ffa_ff'
            )
        );

        if (null === $check_fk_ff) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery -- Custom plugin table.
            $wpdb->query(
                $wpdb->prepare(
				    // phpcs:ignore WordPress.DB.DirectDatabaseQuery.SchemaChange -- Foreign key creation for custom plugin table.
                    'ALTER TABLE %i
                     ADD CONSTRAINT FK_ffa_ff
                     FOREIGN KEY (outerwhisper_ffa_ff_id)
                     REFERENCES %i (outerwhisper_ff_id)
                     ON DELETE CASCADE
                     ON UPDATE NO ACTION',
                    $this->table_name,
                    $feedback_table
                )
            );
        }

        // Foreign Key to FormData
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery -- Checking a foreign key constraint for a custom plugin table.
        $check_fk_fd = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT CONSTRAINT_NAME
                 FROM information_schema.KEY_COLUMN_USAGE
                 WHERE TABLE_SCHEMA = DATABASE()
                   AND TABLE_NAME = %s
                   AND CONSTRAINT_NAME = %s
                   AND REFERENCED_TABLE_NAME IS NOT NULL",
                $this->table_name,
                'FK_ffa_fd'
            )
        );

        if (null === $check_fk_fd) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery -- Custom plugin table.
            $wpdb->query(
                $wpdb->prepare(
				    // phpcs:ignore WordPress.DB.DirectDatabaseQuery.SchemaChange -- Foreign key creation for custom plugin table.
                    'ALTER TABLE %i
                     ADD CONSTRAINT FK_ffa_fd
                     FOREIGN KEY (outerwhisper_ffa_fd_id)
                     REFERENCES %i (outerwhisper_fd_id)
                     ON DELETE CASCADE
                     ON UPDATE NO ACTION',
                    $this->table_name,
                    $form_table
                )
            );
        }
    }

    public function add_answer($data) {
        $feedback_id = isset($data['outerwhisper_ffa_ff_id']) ? (int) $data['outerwhisper_ffa_ff_id'] : 0;
        $form_id     = isset($data['outerwhisper_ffa_fd_id']) ? (int) $data['outerwhisper_ffa_fd_id'] : 0;
        $field_id    = $data['outerwhisper_ffa_field_id'] ?? '';
        $field_type  = $data['outerwhisper_ffa_field_type'] ?? '';
        $num_value   = isset($data['outerwhisper_ffa_num_value']) ? (float) $data['outerwhisper_ffa_num_value'] : null;
        $text_value  = $data['outerwhisper_ffa_text_value'] ?? null;

        $insert_data = [
            'outerwhisper_ffa_ff_id'      => $feedback_id,
            'outerwhisper_ffa_fd_id'      => $form_id,
            'outerwhisper_ffa_field_id'   => $field_id,
            'outerwhisper_ffa_field_type' => $field_type,
            'outerwhisper_ffa_num_value'  => $num_value,
            'outerwhisper_ffa_text_value' => $text_value,
        ];

        $formats = ['%d', '%d', '%s', '%s', '%f', '%s'];

        if (!empty($data['outerwhisper_ffa_created'])) {
            $insert_data['outerwhisper_ffa_created'] = $data['outerwhisper_ffa_created'];
            $formats[] = '%s';
        } elseif (!empty($data['created'])) {
            $insert_data['outerwhisper_ffa_created'] = $data['created'];
            $formats[] = '%s';
        }

        $result = $this->wpdb->insert($this->table_name, $insert_data, $formats);

        return $result ? (int) $this->wpdb->insert_id : false;
    }

    public function add_answers_batch(array $answers) {
        if (empty($answers)) {
            return 0;
        }

        $inserted = 0;
        foreach ($answers as $answer) {
            if ($this->add_answer($answer)) {
                $inserted++;
            }
        }

        return $inserted;
    }

    /**
     * Bulk inserts multiple feedback answers in a single query.
     *
     * @param array $answers Array of answer arrays.
     * @return bool True on success, false on failure.
     */
    public function bulk_insert(array $answers): bool {
        if (empty($answers)) {
            return true;
        }

        $wpdb = $this->wpdb;
        $values = [];
        $placeholders = [];

        foreach ($answers as $answer) {
            $feedback_id = isset($answer['outerwhisper_ffa_ff_id']) ? (int) $answer['outerwhisper_ffa_ff_id'] : 0;
            $form_id     = isset($answer['outerwhisper_ffa_fd_id']) ? (int) $answer['outerwhisper_ffa_fd_id'] : 0;
            $field_id    = $answer['outerwhisper_ffa_field_id'] ?? '';
            $field_type  = $answer['outerwhisper_ffa_field_type'] ?? '';
            $num_value   = isset($answer['outerwhisper_ffa_num_value']) && null !== $answer['outerwhisper_ffa_num_value'] ? (float) $answer['outerwhisper_ffa_num_value'] : null;
            $text_value  = $answer['outerwhisper_ffa_text_value'] ?? null;
            $created     = $answer['outerwhisper_ffa_created'] ?? ($answer['created'] ?? null);

            if ($created) {
                $placeholders[] = '(%d, %d, %s, %s, %s, %s, %s)';
                $values[] = $feedback_id;
                $values[] = $form_id;
                $values[] = $field_id;
                $values[] = $field_type;
                $values[] = $num_value;
                $values[] = $text_value;
                $values[] = $created;
            } else {
                $placeholders[] = '(%d, %d, %s, %s, %s, %s, CURRENT_TIMESTAMP())';
                $values[] = $feedback_id;
                $values[] = $form_id;
                $values[] = $field_id;
                $values[] = $field_type;
                $values[] = $num_value;
                $values[] = $text_value;
            }
        }

        if (empty($placeholders)) {
            return true;
        }

        $query = "INSERT INTO {$this->table_name} (
            outerwhisper_ffa_ff_id,
            outerwhisper_ffa_fd_id,
            outerwhisper_ffa_field_id,
            outerwhisper_ffa_field_type,
            outerwhisper_ffa_num_value,
            outerwhisper_ffa_text_value,
            outerwhisper_ffa_created
        ) VALUES " . implode(', ', $placeholders);

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.PreparedSQL.NotPrepared
        $result = $wpdb->query($wpdb->prepare($query, $values));

        return $result !== false;
    }

    public function get_answer_by_id($id): ?FormFeedbackAnswerEntity {
        $wpdb = $this->wpdb;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery
        $row = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM %i WHERE outerwhisper_ffa_id = %d", [
                $this->table_name,
                (int) $id,
            ]),
            ARRAY_A
        );

        return $row ? new FormFeedbackAnswerEntity($row) : null;
    }

    public function get_answers_by_feedback_id($feedback_id): array {
        $wpdb = $this->wpdb;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery
        $results = $wpdb->get_results(
            $wpdb->prepare("SELECT * FROM %i WHERE outerwhisper_ffa_ff_id = %d ORDER BY outerwhisper_ffa_id ASC", [
                $this->table_name,
                (int) $feedback_id,
            ]),
            ARRAY_A
        );

        $answers = [];
        if ($results) {
            foreach ($results as $row) {
                $answers[] = new FormFeedbackAnswerEntity($row);
            }
        }

        return $answers;
    }

    public function get_answers(array $args = []): array {
        $wpdb = $this->wpdb;

        $orderby = !empty($args['orderby']) ? sanitize_sql_orderby(wp_unslash($args['orderby'])) : 'outerwhisper_ffa_created';
        $order = !empty($args['order']) ? sanitize_text_field(wp_unslash($args['order'])) : 'DESC';
        $limit = isset($args['limit']) ? (int) $args['limit'] : 50;
        $offset = isset($args['offset']) ? (int) $args['offset'] : 0;

        $allowed_orderby = [
            'outerwhisper_ffa_id',
            'outerwhisper_ffa_ff_id',
            'outerwhisper_ffa_fd_id',
            'outerwhisper_ffa_field_id',
            'outerwhisper_ffa_field_type',
            'outerwhisper_ffa_num_value',
            'outerwhisper_ffa_created',
        ];

        if (!in_array($orderby, $allowed_orderby, true)) {
            $orderby = 'outerwhisper_ffa_created';
        }

        $order = (strtoupper($order) === 'ASC') ? 'ASC' : 'DESC';

        $where = $this->apply_filters($args);

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, PluginCheck.Security.DirectDB.UnescapedDBParameter, WordPress.DB.DirectDatabaseQuery.DirectQuery
        $results = $wpdb->get_results(
            $wpdb->prepare(
                // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                "SELECT * FROM %i {$where} ORDER BY {$orderby} {$order} LIMIT %d OFFSET %d",
                $this->table_name,
                $limit,
                $offset
            ),
            ARRAY_A
        );

        $answers = [];
        if ($results) {
            foreach ($results as $row) {
                $answers[] = new FormFeedbackAnswerEntity($row);
            }
        }

        return $answers;
    }

    public function get_answers_count(array $args = []): int {
        $wpdb = $this->wpdb;
        $where = $this->apply_filters($args);

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared, PluginCheck.Security.DirectDB.UnescapedDBParameter
        return (int) $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM %i {$where}", $this->table_name));
    }

    public function delete_answer($id) {
        return $this->wpdb->delete($this->table_name, ['outerwhisper_ffa_id' => (int) $id], ['%d']);
    }

    public function delete_answers_by_feedback_id($feedback_id) {
        return $this->wpdb->delete($this->table_name, ['outerwhisper_ffa_ff_id' => (int) $feedback_id], ['%d']);
    }

    public function delete_answers_by_form_id($form_id) {
        return $this->wpdb->delete($this->table_name, ['outerwhisper_ffa_fd_id' => (int) $form_id], ['%d']);
    }

    public function get_rating_distribution_counts(array $args = []): array {
        $wpdb = $this->wpdb;

        $where_clauses = [
            "outerwhisper_ffa_field_type IN ('rating')",
            "outerwhisper_ffa_num_value IS NOT NULL",
        ];
        $params = [$this->table_name];

        if (!empty($args['form_id']) && 'all' !== $args['form_id']) {
            if (is_array($args['form_id'])) {
                $ids = array_map('intval', $args['form_id']);
                $placeholders = implode(',', array_fill(0, count($ids), '%d'));
                if (!empty($placeholders)) {
                    $where_clauses[] = "outerwhisper_ffa_fd_id IN ($placeholders)";
                    $params = array_merge($params, $ids);
                }
            } else {
                $where_clauses[] = 'outerwhisper_ffa_fd_id = %d';
                $params[] = (int) $args['form_id'];
            }
        }

        if (!empty($args['start_date'])) {
            $where_clauses[] = 'outerwhisper_ffa_created >= %s';
            $params[] = $args['start_date'] . ' 00:00:00';
        }

        if (!empty($args['end_date'])) {
            $where_clauses[] = 'outerwhisper_ffa_created <= %s';
            $params[] = $args['end_date'] . ' 23:59:59';
        }

        $where_sql = implode(' AND ', $where_clauses);

		$sql = "SELECT 
				 outerwhisper_ffa_field_type AS field_type,
				 outerwhisper_ffa_num_value AS num_value,
				 COUNT(*) AS count
                 FROM %i
                 WHERE {$where_sql}
                 GROUP BY outerwhisper_ffa_field_type, outerwhisper_ffa_num_value";

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, PluginCheck.Security.DirectDB.UnescapedDBParameter, WordPress.DB.DirectDatabaseQuery.DirectQuery
		$results = $wpdb->get_results(
		    // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$wpdb->prepare($sql, $params),
		    ARRAY_A
		);

        return is_array($results) ? $results : [];
    }

    private function apply_filters(array $args): string {
        $where = "WHERE 1=1";

        if (!empty($args['feedback_id'])) {
            $where .= $this->wpdb->prepare(" AND outerwhisper_ffa_ff_id = %d", (int) $args['feedback_id']);
        }

        if (!empty($args['form_id']) && 'all' !== $args['form_id']) {
            if (is_array($args['form_id'])) {
                $ids = array_map('intval', $args['form_id']);
                $placeholders = implode(',', array_fill(0, count($ids), '%d'));
                // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.PreparedSQLPlaceholders.UnfinishedPrepare
                $where .= $this->wpdb->prepare(" AND outerwhisper_ffa_fd_id IN ($placeholders)", $ids);
            } else {
                $where .= $this->wpdb->prepare(" AND outerwhisper_ffa_fd_id = %d", (int) $args['form_id']);
            }
        }

        if (!empty($args['field_id'])) {
            $where .= $this->wpdb->prepare(" AND outerwhisper_ffa_field_id = %s", $args['field_id']);
        }

        if (!empty($args['field_type'])) {
            $where .= $this->wpdb->prepare(" AND outerwhisper_ffa_field_type = %s", $args['field_type']);
        }

        if (isset($args['num_value']) && null !== $args['num_value']) {
            $where .= $this->wpdb->prepare(" AND outerwhisper_ffa_num_value = %f", (float) $args['num_value']);
        }

        if (!empty($args['start_date'])) {
            $where .= $this->wpdb->prepare(" AND outerwhisper_ffa_created >= %s", $args['start_date'] . ' 00:00:00');
        }

        if (!empty($args['end_date'])) {
            $where .= $this->wpdb->prepare(" AND outerwhisper_ffa_created <= %s", $args['end_date'] . ' 23:59:59');
        }

        return $where;
    }
}
