<?php
namespace App\Services;

use App\Contracts\Translatable;
use Config;
use Illuminate\Support\Facades\App;
Use Lang;
use Route;
use Illuminate\Support\Facades\Request;

class Multilanguage implements Translatable
{
    protected $prefix;
    protected $alt_languages = array();
	protected $routes;
	protected $locale;

    public function __construct()
    {
        $this->prefix = Request::segment(1);
        $this->alt_languages = Config::get('app.alt_languages');
		$this->routes = Lang::get('routes');
    }

	public function setRoutePattern()
    {
        $this->setLocale();

        foreach(Lang::get('routes') as $key => $value)
            Route::pattern($key, $value);

    }

	public function setLocale()
	{
		if( in_array($this->prefix, $this->alt_languages) )
		{
			App::setLocale($this->prefix);
			Config::set('app.locale_prefix', $this->prefix);

		}
	}

	public function getLocalePrefix()
	{
		$locale = Config::get('app.locale');

		if(in_array($locale, $this->alt_languages))
			return $locale;
		return;
	}

    public function getLocale()
    {
        return Config::get('app.locale');
    }

	public function getLocaleRoutes()
	{
		return $this->routes;
	}

	public function getRoute($slug = null)
	{
		$currentPrefix = $this->getLocalePrefix();
		$url = $currentPrefix.'/'.$this->getLocaleRoute($slug);

		return $url;
	}

	public function getLocaleRoute($slug = null)
	{
		if( array_key_exists($slug, $this->routes) )
			return $url = $this->routes[$slug];

		return $url = $slug;
	}

	public function getPermalink($slug = null)
	{
		$url = $this->getRoute($slug);
		return url($url);
	}
}

?>