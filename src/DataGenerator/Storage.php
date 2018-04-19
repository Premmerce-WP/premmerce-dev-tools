<?php namespace Premmerce\DevTools\DataGenerator;

class Storage
{

    /**
     * @var string
     */
    private $prefix = 'premmerce_dev_tools_generator_';

    private $keys = [
        'attributes',
        'brands',
        'categories',
    ];

    /**
     * @param $data
     *
     * @return bool
     */
    public function setAttributes($data) {
        return $this->set('attributes', $data);
    }

    /**
     * @return mixed|null
     */
    public function getAttributes() {
        return $this->get('attributes');
    }

    /**
     * @param $data
     *
     * @return bool
     */
    public function setBrands($data) {
        return $this->set('brands', $data);
    }

    /**
     * @return mixed|null
     */
    public function getBrands() {
        return $this->get('brands');
    }

	/**
	 * @param $data
	 *
	 * @return bool
	 */
	public function setCategoriesTermTaxonomy($data) {
		return $this->set('categoriesTermTaxonomy', $data);
	}

	/**
	 * @return mixed|null
	 */
	public function getCategoriesTermTaxonomy() {
		return $this->get('categoriesTermTaxonomy');
	}


	/**
     * @param $data
     *
     * @return bool
     */
    public function setCategories($data) {
        return $this->set('categories', $data);
    }

    /**
     * @return mixed|null
     */
    public function getCategories() {
        return $this->get('categories');
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return bool
     */
    public function set($key, $value) {
        return update_option($this->prefix . $key, $value);
    }

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    public function get($key) {
        return get_option($this->prefix . $key, null);
    }

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    public function delete($key) {
        return delete_option($this->prefix . $key);
    }

    public function clear() {
        foreach ($this->keys as $key) {
            $this->delete($key);
        }
    }

}