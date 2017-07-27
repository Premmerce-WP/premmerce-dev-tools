<?php namespace Premmerce\DevTools\FakeData;

class BulkInsertQuery {

	private $data = [];

	/**
	 * @return BulkInsertQuery
	 */
	public static function create() {
		return new self();
	}

	/**
	 * @param string $table
	 *
	 * @return $this
	 */
	public function table( $table ) {
		$this->data['table'] = $table;

		return $this;
	}

	/**
	 * @param array $values
	 *
	 * @return $this
	 */
	public function values( array $values ) {
		$this->data['values'] = $values;

		return $this;
	}

	/**
	 * @return false|int
	 */
	public function query() {
		global $wpdb;

		$q = $this->toString();

		return $wpdb->query( $q );
	}

	/**
	 * @return array|string
	 */
	public function toString() {

		$query[] = sprintf( "INSERT INTO %s (%s)"
			, $this->data['table']
			, implode( ",", array_keys( reset( $this->data['values'] ) ) ) );

		$values = [];

		foreach ( $this->data['values'] as $dataValues ) {
			$values[] = "('" . implode( "','", $dataValues ) . "')";
		}

		$query[] = 'VALUES' . implode( ',', $values ) . ';';

		$query = implode( ' ', $query );

		return $query;
	}


}