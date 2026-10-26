<?php
/**
 * Static OuterWhisper Pro import/export preview.
 *
 * Demo only:
 * - no database access
 * - no file inputs
 * - no import/export handlers
 * - no functional controls
 */

if (!defined('ABSPATH')) {
	exit;
}

$outerwhisperMockForms = array(
	array(
		'id'   => 76,
		'name' => __( 'Content feedback', 'outerwhisper' ),
	),
	array(
		'id'   => 78,
		'name' => __( 'Exit-intent form', 'outerwhisper' ),
	),
	array(
		'id'   => 77,
		'name' => __( 'Feedback button form', 'outerwhisper' ),
	),
);
?>

<section
	id="outerwhisper-view-export-preview"
	class="outerwhisper-view-section outerwhisper-pro-export-preview"
	aria-hidden="true"
>
	<header class="outerwhisper-view-header">
		<h2 style="
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 5px 0;
            color: var(--outerwhisper-primary-color);
        ">
			<?php esc_html_e( 'Data management (import & export)', 'outerwhisper' ); ?>
		</h2>

		<p>
			<?php
			esc_html_e(
				'Manage your form structures, plugin configurations, and collected feedback entries in one central location.',
				'outerwhisper'
			);
			?>
		</p>
	</header>

	<div
		class="outerwhisper-dashboard-grid"
		style="
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 24px;
            margin-top: 24px;
        "
	>

		<!-- Feedback entries -->
		<div
			class="outerwhisper-card-group"
			style="
                display: flex;
                flex-direction: column;
                gap: 20px;
            "
		>

			<div style="
                background: #f1f5f9;
                padding: 12px 16px;
                border-radius: 6px;
                display: flex;
                align-items: center;
                gap: 10px;
                border-left: 4px solid var(--outerwhisper-primary-color);
            ">
				<i
					class="fas fa-database"
					style="
                        color: var(--outerwhisper-primary-color);
                        font-size: 1.1rem;
                    "
				></i>

				<h3 style="
                    margin: 0;
                    font-size: 14px;
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                    color: #1e293b;
                ">
					<?php
					esc_html_e(
						'1. Feedback entries (received user data)',
						'outerwhisper'
					);
					?>
				</h3>
			</div>

			<!-- Export feedback -->
			<div
				class="outerwhisper-admin-card"
				style="
                    margin-top: 0;
                    padding: 24px;
                    background: #fff;
                    border: 1px solid var(--outerwhisper-border-color);
                    border-radius: var(--outerwhisper-radius);
                    box-shadow: var(--outerwhisper-shadow);
                "
			>

				<div style="
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    margin-bottom: 20px;
                ">
					<div style="
                        color: var(--outerwhisper-primary-color);
                        width: 44px;
                        height: 44px;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 1.3rem;
                    ">
						<i class="fas fa-file-export"></i>
					</div>

					<div>
						<h4 style="
                            margin: 0;
                            font-size: 16px;
                            font-weight: 600;
                            color: var(--outerwhisper-text-main);
                        ">
							<?php esc_html_e( 'Export entries', 'outerwhisper' ); ?>
						</h4>

						<p style="
                            margin: 2px 0 0 0;
                            font-size: 13px;
                            color: var(--outerwhisper-text-secondary);
                        ">
							<?php
							esc_html_e(
								'Select your filters and download the feedback data in the desired format.',
								'outerwhisper'
							);
							?>
						</p>
					</div>
				</div>

				<div
					class="outerwhisper-export-filters"
					style="
                        display: flex;
                        flex-direction: column;
                        gap: 12px;
                        margin-bottom: 20px;
                        background: #f8fafc;
                        padding: 16px;
                        border-radius: 6px;
                        border: 1px solid #e2e8f0;
                    "
				>

					<div style="
                        display: flex;
                        flex-direction: column;
                        gap: 5px;
                    ">
						<label style="
                            font-size: 11px;
                            font-weight: 600;
                            color: #475569;
                            text-transform: uppercase;
                            margin-bottom: 4px;
                        ">
							<?php esc_html_e( 'Filter by form', 'outerwhisper' ); ?>
						</label>

						<div
							class="outerwhisper-feedback-form-checkbox-list"
							style="
                                background: #fff;
                                border: 1px solid #cbd5e1;
                                border-radius: 6px;
                                max-height: 150px;
                                overflow-y: auto;
                                padding: 10px;
                                display: flex;
                                flex-direction: column;
                                gap: 8px;
                            "
						>

							<label style="
                                display: flex;
                                align-items: center;
                                gap: 8px;
                                font-size: 13px;
                                font-weight: 600;
                            ">
								<input
									type="checkbox"
									checked
									disabled
									tabindex="-1"
									style="width: 16px; height: 16px;"
								>

								<span>
                                    <?php esc_html_e( 'Select all forms', 'outerwhisper' ); ?>
                                </span>
							</label>

							<div style="
                                border-top: 1px solid #e2e8f0;
                                margin: 2px 0;
                            "></div>

							<?php foreach ( $outerwhisperMockForms as $outerwhisperMockForm ) : ?>

								<label style="
                                    display: flex;
                                    align-items: center;
                                    gap: 8px;
                                    font-size: 13px;
                                    padding-left: 2px;
                                ">
									<input
										type="checkbox"
										checked
										disabled
										tabindex="-1"
										style="width: 16px; height: 16px;"
									>

									<span>
                                        <?php
										printf(
											'%s - %s',
	                                        esc_html( $outerwhisperMockForm['id'] ),
	                                        esc_html( $outerwhisperMockForm['name'] )
										);
										?>
                                    </span>
								</label>

							<?php endforeach; ?>

						</div>
					</div>

					<div style="
                        display: grid;
                        grid-template-columns: 1fr 1fr;
                        gap: 12px;
                    ">

						<div style="
                            display: flex;
                            flex-direction: column;
                            gap: 5px;
                        ">
							<label style="
                                font-size: 11px;
                                font-weight: 600;
                                color: #475569;
                                text-transform: uppercase;
                            ">
								<?php esc_html_e( 'Time period', 'outerwhisper' ); ?>
							</label>

							<select
								disabled
								tabindex="-1"
								style="
                                    width: 100%;
                                    padding: 8px 12px;
                                    border: 1px solid #cbd5e1;
                                    border-radius: 4px;
                                    font-size: 13px;
                                    background: #fff;
                                "
							>
								<option>
									<?php esc_html_e( 'Last 30 days', 'outerwhisper' ); ?>
								</option>
							</select>
						</div>

						<div style="
                            display: flex;
                            flex-direction: column;
                            gap: 5px;
                        ">
							<label style="
                                font-size: 11px;
                                font-weight: 600;
                                color: #475569;
                                text-transform: uppercase;
                            ">
								<?php esc_html_e( 'Status', 'outerwhisper' ); ?>
							</label>

							<select
								disabled
								tabindex="-1"
								style="
                                    width: 100%;
                                    padding: 8px 12px;
                                    border: 1px solid #cbd5e1;
                                    border-radius: 4px;
                                    font-size: 13px;
                                    background: #fff;
                                "
							>
								<option>
									<?php esc_html_e( 'All entries', 'outerwhisper' ); ?>
								</option>
							</select>
						</div>

					</div>
				</div>

				<p style="
                    margin: 0 0 20px 0;
                    font-size: 12px;
                    color: #64748b;
                    line-height: 1.5;
                    padding: 10px 14px;
                    background: #f0f9ff;
                    border-radius: 6px;
                    border: 1px solid #e0f2fe;
                ">
					<i
						class="fas fa-info-circle"
						style="
                            color: #0284c7;
                            margin-right: 6px;
                        "
					></i>

					<strong>
						<?php esc_html_e( 'Export hint:', 'outerwhisper' ); ?>
					</strong>

					<?php
					esc_html_e(
						'CSV contains dynamic columns (each question in your form gets its own column). JSON provides structured raw data including detailed device and meta data.',
						'outerwhisper'
					);
					?>
				</p>

				<div style="
                    display: flex;
                    gap: 12px;
                    width: 100%;
                ">

                    <span
						class="outerwhisper-btn-primary"
						style="
                            flex: 1;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            gap: 8px;
                            font-size: 13px;
                        "
					>
                        <i class="fas fa-file-csv"></i>
                        <?php esc_html_e( 'Download CSV', 'outerwhisper' ); ?>
                    </span>

					<span
						class="outerwhisper-btn-secondary"
						style="
                            flex: 1;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            gap: 8px;
                            font-size: 13px;
                        "
					>
                        <i class="fas fa-file-code"></i>
                        <?php esc_html_e( 'Download JSON', 'outerwhisper' ); ?>
                    </span>

				</div>
			</div>

			<!-- Import feedback -->
			<div
				class="outerwhisper-admin-card"
				style="
                    margin-top: 0;
                    padding: 24px;
                    background: #fff;
                    border: 1px solid var(--outerwhisper-border-color);
                    border-radius: var(--outerwhisper-radius);
                    box-shadow: var(--outerwhisper-shadow);
                "
			>

				<div style="
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    margin-bottom: 16px;
                ">
					<div style="
                        background: #f0fdf4;
                        color: var(--outerwhisper-primary-color);
                        width: 44px;
                        height: 44px;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 1.3rem;
                    ">
						<i class="fas fa-file-import"></i>
					</div>

					<div>
						<h4 style="
                            margin: 0;
                            font-size: 16px;
                            font-weight: 600;
                            color: var(--outerwhisper-text-main);
                        ">
							<?php esc_html_e( 'Import feedbacks', 'outerwhisper' ); ?>
						</h4>

						<p style="
                            margin: 2px 0 0 0;
                            font-size: 13px;
                            color: var(--outerwhisper-text-secondary);
                        ">
							<?php
							esc_html_e(
								'Upload an exported feedback file (.json) to restore entries.',
								'outerwhisper'
							);
							?>
						</p>
					</div>
				</div>

				<div style="
                    background: #f8fafc;
                    border: 2px dashed #cbd5e1;
                    border-radius: 8px;
                    padding: 28px 16px;
                    text-align: center;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    gap: 8px;
                ">
					<i
						class="fas fa-cloud-upload-alt"
						style="
                            font-size: 2.2rem;
                            color: var(--outerwhisper-primary-color);
                        "
					></i>

					<span style="
                        font-size: 14px;
                        font-weight: 600;
                        color: #1e293b;
                    ">
                        <?php esc_html_e( 'Select or drag file', 'outerwhisper' ); ?>
                    </span>

					<span style="
                        font-size: 12px;
                        color: var(--outerwhisper-text-secondary);
                    ">
                        <?php
						esc_html_e(
							'Supports .json feedback files',
	                        'outerwhisper'
						);
						?>
                    </span>
				</div>

			</div>
		</div>


		<!-- Form structures -->
		<div
			class="outerwhisper-card-group"
			style="
                display: flex;
                flex-direction: column;
                gap: 20px;
            "
		>

			<div style="
                background: #f1f5f9;
                padding: 12px 16px;
                border-radius: 6px;
                display: flex;
                align-items: center;
                gap: 10px;
                border-left: 4px solid var(--outerwhisper-primary-color);
            ">
				<i
					class="fas fa-file-alt"
					style="
                        color: var(--outerwhisper-primary-color);
                        font-size: 1.1rem;
                    "
				></i>

				<h3 style="
                    margin: 0;
                    font-size: 14px;
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                    color: #1e293b;
                ">
					<?php
					esc_html_e(
						'2. Form structures (templates)',
						'outerwhisper'
					);
					?>
				</h3>
			</div>

			<!-- Export forms -->
			<div
				class="outerwhisper-admin-card"
				style="
                    margin-top: 0;
                    padding: 24px;
                    background: #fff;
                    border: 1px solid var(--outerwhisper-border-color);
                    border-radius: var(--outerwhisper-radius);
                    box-shadow: var(--outerwhisper-shadow);
                "
			>

				<div style="
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    margin-bottom: 16px;
                ">
					<div style="
                        color: var(--outerwhisper-primary-color);
                        width: 44px;
                        height: 44px;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 1.3rem;
                    ">
						<i class="fas fa-file-export"></i>
					</div>

					<div>
						<h4 style="
                            margin: 0;
                            font-size: 16px;
                            font-weight: 600;
                            color: var(--outerwhisper-text-main);
                        ">
							<?php esc_html_e( 'Export forms', 'outerwhisper' ); ?>
						</h4>

						<p style="
                            margin: 2px 0 0 0;
                            font-size: 13px;
                            color: var(--outerwhisper-text-secondary);
                        ">
							<?php
							esc_html_e(
								'Export selected form layouts as .json for other WordPress instances.',
								'outerwhisper'
							);
							?>
						</p>
					</div>
				</div>

				<div style="
                    display: flex;
                    flex-direction: column;
                    gap: 12px;
                    background: #f8fafc;
                    border: 1px solid #e2e8f0;
                    padding: 16px;
                    border-radius: 6px;
                    margin-bottom: 16px;
                ">

					<div style="
                        display: flex;
                        flex-direction: column;
                        gap: 5px;
                    ">

						<label style="
                            font-size: 11px;
                            font-weight: 600;
                            color: #64748b;
                            text-transform: uppercase;
                            margin-bottom: 4px;
                        ">
							<?php
							esc_html_e(
								'Which forms would you like to export?',
								'outerwhisper'
							);
							?>
						</label>

						<div
							class="outerwhisper-form-checkbox-list"
							style="
                                background: #fff;
                                border: 1px solid #cbd5e1;
                                border-radius: 6px;
                                max-height: 150px;
                                overflow-y: auto;
                                padding: 10px;
                                display: flex;
                                flex-direction: column;
                                gap: 8px;
                            "
						>

							<label style="
                                display: flex;
                                align-items: center;
                                gap: 8px;
                                font-size: 13px;
                                font-weight: 600;
                            ">
								<input
									type="checkbox"
									checked
									disabled
									tabindex="-1"
									style="width: 16px; height: 16px;"
								>

								<span>
                                    <?php esc_html_e( 'Select all forms', 'outerwhisper' ); ?>
                                </span>
							</label>

							<div style="
                                border-top: 1px solid #e2e8f0;
                                margin: 2px 0;
                            "></div>

							<?php foreach ( $outerwhisperMockForms as $outerwhisperMockForm ) : ?>

								<label style="
                                    display: flex;
                                    align-items: center;
                                    gap: 8px;
                                    font-size: 13px;
                                    padding-left: 2px;
                                ">
									<input
										type="checkbox"
										checked
										disabled
										tabindex="-1"
										style="width: 16px; height: 16px;"
									>

									<span>
                                        <?php
										printf(
											'%s - %s',
	                                        esc_html( $outerwhisperMockForm['id'] ),
	                                        esc_html( $outerwhisperMockForm['name'] )
										);
										?>
                                    </span>
								</label>

							<?php endforeach; ?>

						</div>
					</div>

					<span
						class="outerwhisper-btn-primary"
						style="
                            width: 100%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            gap: 8px;
                            font-size: 13px;
                            box-sizing: border-box;
                        "
					>
                        <i class="fas fa-download"></i>

                        <?php
						esc_html_e(
							'Export layout(s) (.json)',
	                        'outerwhisper'
						);
						?>
                    </span>

				</div>

				<p style="
                    margin: 0;
                    font-size: 12px;
                    color: #64748b;
                    line-height: 1.4;
                ">
					<i
						class="fas fa-info-circle"
						style="color: var(--outerwhisper-primary-color);"
					></i>

					<?php
					esc_html_e(
						'Ideal for transferring from a test (staging) to a live environment.',
						'outerwhisper'
					);
					?>
				</p>

			</div>

			<!-- Import forms -->
			<div
				class="outerwhisper-admin-card"
				style="
                    margin-top: 0;
                    padding: 24px;
                    background: #fff;
                    border: 1px solid var(--outerwhisper-border-color);
                    border-radius: var(--outerwhisper-radius);
                    box-shadow: var(--outerwhisper-shadow);
                "
			>

				<div style="
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    margin-bottom: 16px;
                ">
					<div style="
                        color: var(--outerwhisper-primary-color);
                        width: 44px;
                        height: 44px;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 1.3rem;
                    ">
						<i class="fas fa-file-import"></i>
					</div>

					<div>
						<h4 style="
                            margin: 0;
                            font-size: 16px;
                            font-weight: 600;
                            color: var(--outerwhisper-text-main);
                        ">
							<?php esc_html_e( 'Import forms', 'outerwhisper' ); ?>
						</h4>

						<p style="
                            margin: 2px 0 0 0;
                            font-size: 13px;
                            color: var(--outerwhisper-text-secondary);
                        ">
							<?php
							esc_html_e(
								'Upload an exported form layout (.json) to add it. Note that existing form data with the same form ID will be overwritten.',
								'outerwhisper'
							);
							?>
						</p>
					</div>
				</div>

				<div style="
                    background: #f8fafc;
                    border: 2px dashed #cbd5e1;
                    border-radius: 8px;
                    padding: 28px 16px;
                    text-align: center;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    gap: 8px;
                ">
					<i
						class="fas fa-cloud-upload-alt"
						style="
                            font-size: 2.2rem;
                            color: var(--outerwhisper-primary-color);
                        "
					></i>

					<span style="
                        font-size: 14px;
                        font-weight: 600;
                        color: #1e293b;
                    ">
                        <?php esc_html_e( 'Select or drag file', 'outerwhisper' ); ?>
                    </span>

					<span style="
                        font-size: 12px;
                        color: var(--outerwhisper-text-secondary);
                    ">
                        <?php
						esc_html_e(
							'Supports .json form files (single or multiple forms)',
	                        'outerwhisper'
						);
						?>
                    </span>
				</div>

			</div>
		</div>

	</div>
</section>