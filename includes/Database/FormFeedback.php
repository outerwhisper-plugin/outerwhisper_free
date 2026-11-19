<?php

namespace OuterWhisper\Database;

class FormFeedback extends Database {
    public function __construct() {
        parent::__construct();
        $this->table_name = $this->wpdb->prefix . 'outerwhisper_form_feedback';
    }

    public function create_table() {
        $charset_collate = $this->wpdb->get_charset_collate();

        $sql = "CREATE TABLE $this->table_name (
            outerwhisper_ff_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            outerwhisper_ff_fd_id INT(11) UNSIGNED NOT NULL,
            outerwhisper_ff_form_type ENUM('shortcode','pre-content','post-content','feedback-button','overlay','slide-in','modal') NOT NULL,
            outerwhisper_ff_feedback_data LONGTEXT NULL DEFAULT NULL,
            outerwhisper_ff_feedback_score FLOAT UNSIGNED NULL DEFAULT NULL,
            outerwhisper_ff_tracking_data LONGTEXT NULL DEFAULT NULL,
            outerwhisper_ff_tracking_page_url TEXT NULL DEFAULT NULL,
            outerwhisper_ff_identifier VARCHAR(50) NOT NULL DEFAULT '',
            outerwhisper_ff_status ENUM('unread','read','archived') NOT NULL DEFAULT 'unread',
            outerwhisper_ff_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
            outerwhisper_ff_updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
            PRIMARY KEY (outerwhisper_ff_id),
            INDEX outerwhisper_ff_status (outerwhisper_ff_status),
            INDEX outerwhisper_ff_form_type (outerwhisper_ff_form_type),
            INDEX outerwhisper_ff_created (outerwhisper_ff_created),
            INDEX outerwhisper_ff_identifier (outerwhisper_ff_identifier),
            INDEX FK_ff_fd (outerwhisper_ff_fd_id),
            INDEX outerwhisper_ff_feedback_score (outerwhisper_ff_feedback_score),
            INDEX outerwhisper_ff_fd_id_created (outerwhisper_ff_fd_id, outerwhisper_ff_created),
			INDEX outerwhisper_ff_feedback_score_status_created (outerwhisper_ff_feedback_score, outerwhisper_ff_status, outerwhisper_ff_created)
        ) $charset_collate ENGINE=InnoDB;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        // Add foreign key if it doesn't exist
        $this->add_foreign_key();
    }

    private function add_foreign_key() {
		$wpdb = $this->wpdb;

        $form_table = $wpdb->prefix . 'outerwhisper_form_data';

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery -- Checking a foreign key constraint for a custom plugin table.
		$check_fk = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT CONSTRAINT_NAME
				 FROM information_schema.KEY_COLUMN_USAGE
				 WHERE TABLE_SCHEMA = DATABASE()
				   AND TABLE_NAME = %s
				   AND CONSTRAINT_NAME = %s
				   AND REFERENCED_TABLE_NAME IS NOT NULL",
				$this->table_name,
				'FK_ff_fd'
			)
		);

		if (null !== $check_fk) {
			return;
		}

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery -- Custom plugin table.
		$wpdb->query(
			$wpdb->prepare(
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.SchemaChange -- Foreign key creation for custom plugin table.
				'ALTER TABLE %i
					 ADD CONSTRAINT FK_ff_fd
					 FOREIGN KEY (outerwhisper_ff_fd_id)
					 REFERENCES %i (outerwhisper_fd_id)
					 ON DELETE CASCADE
					 ON UPDATE NO ACTION',
			    $this->table_name,
			    $form_table
			)
		);
	}

    private function apply_filters($args) {
        $where = "WHERE 1=1";

        if (!empty($args['form_id'])) {
            if (is_array($args['form_id'])) {
                $ids = array_map('intval', $args['form_id']);
                $placeholders = implode(',', array_fill(0, count($ids), '%d'));
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.PreparedSQLPlaceholders.UnfinishedPrepare -- Placeholders are generated exclusively from %d; values are bound via prepare().
                $where .= $this->wpdb->prepare(" AND outerwhisper_ff_fd_id IN ($placeholders)", $ids);
            } else {
                $where .= $this->wpdb->prepare(" AND outerwhisper_ff_fd_id = %d", $args['form_id']);
            }
        }

        if (!empty($args['status'])) {
            $where .= $this->wpdb->prepare(" AND outerwhisper_ff_status = %s", $args['status']);
        }

        if (!empty($args['identifier'])) {
            $where .= $this->wpdb->prepare(" AND outerwhisper_ff_identifier = %s", $args['identifier']);
        }

        if (!empty($args['form_type'])) {
            $where .= $this->wpdb->prepare(" AND outerwhisper_ff_form_type = %s", $args['form_type']);
        }

        $start_date = !empty($args['start_date']) ? $args['start_date'] : null;
        $end_date = !empty($args['end_date']) ? $args['end_date'] : null;

        if (!empty($args['range']) && empty($start_date) && empty($end_date)) {
            switch ($args['range']) {
                case 'last_7_days':
                    $start_date = gmdate('Y-m-d', strtotime('-6 days'));
                    break;
                case 'last_30_days':
                    $start_date = gmdate('Y-m-d', strtotime('-29 days'));
                    break;
            }
        }

        if (!empty($start_date)) {
            $where .= $this->wpdb->prepare(" AND outerwhisper_ff_created >= %s", $start_date . ' 00:00:00');
        }
        if (!empty($end_date)) {
            $where .= $this->wpdb->prepare(" AND outerwhisper_ff_created <= %s", $end_date . ' 23:59:59');
        }

        return $where;
    }

    public function get_feedbacks($args = []) {
		$wpdb = $this->wpdb;

        $orderby = !empty($args['orderby']) ? sanitize_sql_orderby(wp_unslash($args['orderby'])) : 'outerwhisper_ff_created';
        $order = !empty($args['order']) ? sanitize_text_field(wp_unslash($args['order'])) : 'DESC';
        $limit = isset($args['limit']) ? (int) $args['limit'] : 50;
        $offset = isset($args['offset']) ? (int) $args['offset'] : 0;

        $where = $this->apply_filters($args);

        $allowed_orderby = ['outerwhisper_ff_id', 'outerwhisper_ff_created', 'outerwhisper_ff_fd_id', 'outerwhisper_ff_feedback_score', 'outerwhisper_ff_status', 'outerwhisper_ff_identifier'];
        if (!in_array($orderby, $allowed_orderby)) {
            $orderby = 'outerwhisper_ff_created';
        }

        $order = (strtoupper($order) === 'ASC') ? 'ASC' : 'DESC';

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, PluginCheck.Security.DirectDB.UnescapedDBParameter, WordPress.DB.DirectDatabaseQuery.DirectQuery
		$results = $wpdb->get_results(
			$wpdb->prepare(
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
				"SELECT * FROM %i {$where} ORDER BY {$orderby} {$order} LIMIT %d OFFSET %d", [
					$this->table_name, $limit, $offset
				]
			),
			ARRAY_A
		);

        $feedbacks = [];
        if ($results) {
            foreach ($results as $row) {
                $feedbacks[] = new \OuterWhisper\Database\Entity\FormFeedback($row);
            }
        }
        
        return $feedbacks;
    }

    public function get_feedback_count($args = []) {
		$wpdb = $this->wpdb;

        $where = $this->apply_filters($args);

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared, PluginCheck.Security.DirectDB.UnescapedDBParameter
        return (int) $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM %i {$where}", $this->table_name));
    }

	public function get_top_forms($args = []) {
		$wpdb = $this->wpdb;
		$form_table = $this->wpdb->prefix . 'outerwhisper_form_data';

		$limit = isset($args['limit']) ? max(1, (int) $args['limit']) : 5;
		$offset = isset($args['offset']) ? max(0, (int) $args['offset']) : 0;

		$where_clauses = ['1=1'];
		$params = [$this->table_name, $form_table];

		if (!empty($args['start_date'])) {
			$where_clauses[] = 'ff.outerwhisper_ff_created >= %s';
			$params[] = $args['start_date'];
		}
		if (!empty($args['end_date'])) {
			$where_clauses[] = 'ff.outerwhisper_ff_created <= %s';
			$params[] = $args['end_date'];
		}

		if (!empty($args['form_id']) && 'all' !== $args['form_id']) {
			if (is_array($args['form_id'])) {
				$ids = array_map('intval', $args['form_id']);
				$placeholders = implode(',', array_fill(0, count($ids), '%d'));
				if (!empty($placeholders)) {
					$where_clauses[] = "ff.outerwhisper_ff_fd_id IN ($placeholders)";
					$params = array_merge($params, $ids);
				}
			} else {
				$where_clauses[] = 'ff.outerwhisper_ff_fd_id = %d';
				$params[] = (int) $args['form_id'];
			}
		}

		$where_sql = implode(' AND ', $where_clauses);
		$params[] = $limit;
		$params[] = $offset;

		$sql = "SELECT 
			fd.outerwhisper_fd_id AS form_id,
			COALESCE(fd.outerwhisper_fd_name, '') AS form_name,
			COUNT(ff.outerwhisper_ff_id) AS feedback_count,
			AVG(ff.outerwhisper_ff_feedback_score) AS avg_score
		FROM %i ff
		INNER JOIN %i fd ON ff.outerwhisper_ff_fd_id = fd.outerwhisper_fd_id
		WHERE {$where_sql}
		GROUP BY fd.outerwhisper_fd_id, fd.outerwhisper_fd_name
		ORDER BY feedback_count DESC, avg_score DESC
		LIMIT %d OFFSET %d";

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, PluginCheck.Security.DirectDB.UnescapedDBParameter, WordPress.DB.DirectDatabaseQuery.DirectQuery
		$results = $wpdb->get_results(
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$wpdb->prepare($sql, $params),
			ARRAY_A
		);

		return $results ?: [];
	}

	public function get_top_pages($args = []) {
		$wpdb = $this->wpdb;

		$limit        = isset($args['limit']) ? max(1, (int) $args['limit']) : 5;
		$offset       = isset($args['offset']) ? max(0, (int) $args['offset']) : 0;
		$has_previous = !empty($args['has_previous']) && !empty($args['prev_start_date']) && !empty($args['prev_end_date']);

		$where_clauses = [
			'outerwhisper_ff_tracking_page_url IS NOT NULL',
			"outerwhisper_ff_tracking_page_url != ''",
		];
		$params = [];

		if ($has_previous) {
			$where_clauses[] = 'outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s';
			$params[] = $args['prev_start_date'];
			$params[] = $args['end_date'];
		} elseif (!empty($args['start_date']) && !empty($args['end_date'])) {
			$where_clauses[] = 'outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s';
			$params[] = $args['start_date'];
			$params[] = $args['end_date'];
		}

		if (!empty($args['form_id']) && 'all' !== $args['form_id']) {
			if (is_array($args['form_id'])) {
				$ids = array_map('intval', $args['form_id']);
				$placeholders = implode(',', array_fill(0, count($ids), '%d'));
				if (!empty($placeholders)) {
					$where_clauses[] = "outerwhisper_ff_fd_id IN ($placeholders)";
					$params = array_merge($params, $ids);
				}
			} else {
				$where_clauses[] = 'outerwhisper_ff_fd_id = %d';
				$params[] = (int) $args['form_id'];
			}
		}

		$where_sql = implode(' AND ', $where_clauses);

		if ($has_previous) {
			$sql = "SELECT 
				outerwhisper_ff_tracking_page_url AS page_url,
				COUNT(CASE WHEN outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s THEN 1 END) AS feedback_count,
				AVG(CASE WHEN outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s THEN outerwhisper_ff_feedback_score END) AS avg_score,
				AVG(CASE WHEN outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s THEN outerwhisper_ff_feedback_score END) AS prev_avg_score
			FROM %i
			WHERE {$where_sql}
			GROUP BY outerwhisper_ff_tracking_page_url
			HAVING feedback_count > 0
			ORDER BY avg_score DESC, feedback_count DESC
			LIMIT %d OFFSET %d";

			$query_params = array_merge(
				[
					$args['start_date'], $args['end_date'],
					$args['start_date'], $args['end_date'],
					$args['prev_start_date'], $args['prev_end_date'],
					$this->table_name,
				],
				$params,
				[$limit, $offset]
			);
		} else {
			$sql = "SELECT 
				outerwhisper_ff_tracking_page_url AS page_url,
				COUNT(outerwhisper_ff_id) AS feedback_count,
				AVG(outerwhisper_ff_feedback_score) AS avg_score,
				NULL AS prev_avg_score
			FROM %i
			WHERE {$where_sql}
			GROUP BY outerwhisper_ff_tracking_page_url
			ORDER BY avg_score DESC, feedback_count DESC
			LIMIT %d OFFSET %d";

			$query_params = array_merge(
				[$this->table_name],
				$params,
				[$limit, $offset]
			);
		}

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, PluginCheck.Security.DirectDB.UnescapedDBParameter, WordPress.DB.DirectDatabaseQuery.DirectQuery
		$results = $wpdb->get_results(
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$wpdb->prepare($sql, $query_params),
			ARRAY_A
		);

		return $results ?: [];
	}

	public function get_display_type_counts($args = []) {
		$wpdb = $this->wpdb;

		$where_clauses = ['1=1'];
		$params = [$this->table_name];

		if (!empty($args['start_date'])) {
			$where_clauses[] = 'outerwhisper_ff_created >= %s';
			$params[] = $args['start_date'];
		}
		if (!empty($args['end_date'])) {
			$where_clauses[] = 'outerwhisper_ff_created <= %s';
			$params[] = $args['end_date'];
		}

		if (!empty($args['form_id']) && 'all' !== $args['form_id']) {
			if (is_array($args['form_id'])) {
				$ids = array_map('intval', $args['form_id']);
				$placeholders = implode(',', array_fill(0, count($ids), '%d'));
				if (!empty($placeholders)) {
					$where_clauses[] = "outerwhisper_ff_fd_id IN ($placeholders)";
					$params = array_merge($params, $ids);
				}
			} else {
				$where_clauses[] = 'outerwhisper_ff_fd_id = %d';
				$params[] = (int) $args['form_id'];
			}
		}

		$where_sql = implode(' AND ', $where_clauses);

		$sql = "SELECT 
			outerwhisper_ff_form_type AS form_type,
			COUNT(outerwhisper_ff_id) AS feedback_count
		FROM %i
		WHERE {$where_sql}
		GROUP BY outerwhisper_ff_form_type";

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, PluginCheck.Security.DirectDB.UnescapedDBParameter, WordPress.DB.DirectDatabaseQuery.DirectQuery
		$results = $wpdb->get_results(
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$wpdb->prepare($sql, $params),
			ARRAY_A
		);

		return $results ?: [];
	}

	public function get_trend_data($args = []) {
		$wpdb = $this->wpdb;

		$group_by = $args['group_by'] ?? 'day';
		$where_clauses = ['1=1'];
		$params = [$this->table_name];

		if (!empty($args['start_date'])) {
			$where_clauses[] = 'outerwhisper_ff_created >= %s';
			$params[] = $args['start_date'];
		}
		if (!empty($args['end_date'])) {
			$where_clauses[] = 'outerwhisper_ff_created <= %s';
			$params[] = $args['end_date'];
		}

		if (!empty($args['form_id']) && 'all' !== $args['form_id']) {
			if (is_array($args['form_id'])) {
				$ids = array_map('intval', $args['form_id']);
				$placeholders = implode(',', array_fill(0, count($ids), '%d'));
				if (!empty($placeholders)) {
					$where_clauses[] = "outerwhisper_ff_fd_id IN ($placeholders)";
					$params = array_merge($params, $ids);
				}
			} else {
				$where_clauses[] = 'outerwhisper_ff_fd_id = %d';
				$params[] = (int) $args['form_id'];
			}
		}

		$date_format = '%%Y-%%m-%%d';
		if ($group_by === 'hour') {
			$date_format = '%%Y-%%m-%%d %%H:00:00';
		} elseif ($group_by === 'month') {
			$date_format = '%%Y-%%m-01';
		}

		$where_sql = implode(' AND ', $where_clauses);

		$sql = "SELECT 
			DATE_FORMAT(outerwhisper_ff_created, '{$date_format}') AS bucket_date,
			COUNT(outerwhisper_ff_id) AS feedback_count,
			AVG(outerwhisper_ff_feedback_score) AS avg_score
		FROM %i
		WHERE {$where_sql}
		GROUP BY bucket_date
		ORDER BY bucket_date ASC";

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, PluginCheck.Security.DirectDB.UnescapedDBParameter, WordPress.DB.DirectDatabaseQuery.DirectQuery
		$results = $wpdb->get_results(
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$wpdb->prepare($sql, $params),
			ARRAY_A
		);

		return $results ?: [];
	}

	public function get_earliest_created_date(): ?string {
		$wpdb = $this->wpdb;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery
		$result = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT MIN(outerwhisper_ff_created) FROM %i WHERE outerwhisper_ff_created IS NOT NULL",
				$this->table_name
			)
		);

		return $result ?: null;
	}

    private function getPreparedTrackingData($tracking_data) {
		return [
			'tracking_page_url' => $tracking_data['url'] ?? '',
		];
    }

    public function add_feedback($data) {
        $feedback_data = $data['feedback_data'] ?? [];
        if (is_array($feedback_data)) {
            $feedback_data = json_encode($feedback_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $tracking_data = $data['tracking_data'] ?? [];
        $tracking_data_encoded = $tracking_data;
        if (is_array($tracking_data)) {
            $tracking_data_encoded = json_encode($tracking_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $prepared_tracking = $this->getPreparedTrackingData($tracking_data);

        $insert_data = [
            'outerwhisper_ff_fd_id'                 => (int) $data['form_id'],
            'outerwhisper_ff_form_type'             => sanitize_text_field($data['form_type'] ?? 'shortcode'),
            'outerwhisper_ff_feedback_data'         => $feedback_data,
			'outerwhisper_ff_feedback_score'        => is_numeric($data['feedback_score']) ? sanitize_text_field($data['feedback_score']) : null,
            'outerwhisper_ff_tracking_data'         => $tracking_data_encoded,
            'outerwhisper_ff_tracking_page_url'     => $prepared_tracking['tracking_page_url'],
            'outerwhisper_ff_identifier'            => !empty($data['identifier']) ? $data['identifier'] : (!empty($data['outerwhisper_ff_identifier']) ? $data['outerwhisper_ff_identifier'] : uniqid('', true)),
            'outerwhisper_ff_status'                => sanitize_text_field($data['status'] ?? 'unread')
        ];

        $formats = ['%d', '%s', '%s', '%f', '%s', '%s', '%s', '%s'];

        if (!empty($data['created'])) {
            $insert_data['outerwhisper_ff_created'] = $data['created'];
            $formats[] = '%s';
        }

        $result = $this->wpdb->insert($this->table_name, $insert_data, $formats);

        return $result ? (int) $this->wpdb->insert_id : false;
    }

    public function update_status($id, $status) {
        $allowed_status = ['unread', 'read', 'archived'];
        if (!in_array($status, $allowed_status)) {
            return false;
        }

        return $this->wpdb->update(
            $this->table_name,
            ['outerwhisper_ff_status' => $status],
            ['outerwhisper_ff_id' => $id],
            ['%s'],
            ['%d']
        );
    }

    public function delete_feedback($id) {
        return $this->wpdb->delete($this->table_name, ['outerwhisper_ff_id' => $id], ['%d']);
    }

    public function get_feedback_by_id($id) {
		$wpdb = $this->wpdb;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery
        $row = $wpdb->get_row(
			$wpdb->prepare("SELECT * FROM %i WHERE outerwhisper_ff_id = %d", [
				$this->table_name,
				$id
			]),
			ARRAY_A
		);

        return $row ? new \OuterWhisper\Database\Entity\FormFeedback($row) : null;
    }

    public function get_distinct_page_urls(): array {
        $wpdb = $this->wpdb;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery
        $results = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT DISTINCT outerwhisper_ff_tracking_page_url 
                 FROM %i 
                 WHERE outerwhisper_ff_tracking_page_url IS NOT NULL 
                   AND outerwhisper_ff_tracking_page_url != '' 
                 ORDER BY outerwhisper_ff_tracking_page_url ASC",
                $this->table_name
            )
        );

        return is_array($results) ? $results : [];
    }
}
