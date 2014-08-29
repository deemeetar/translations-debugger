<?php namespace Deemeetar\TranslationsDebugger;


use Illuminate\Translation\TranslationServiceProvider as BaseTranslationServiceProvider;

class TranslationServiceProvider extends BaseTranslationServiceProvider {


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerLoader();

        $this->package('deemeetar/translations-debugger');

        $this->app->bindShared('translator', function($app)
        {
            $loader = $app['translation.loader'];

            // When registering the translator component, we'll need to set the default
            // locale as well as the fallback locale. So, we'll grab the application
            // configuration so we can easily get both of these values from there.
            $locale = $app['config']['app.locale'];

            $trans = new Translator($loader, $locale);

            $trans->setFallback($app['config']['app.fallback_locale']);

            return $trans;
        });

    }

    public function boot()
    {
        $this->app->after(function($request, $response){
            $this->modifyResponse($response);
        });
    }

    public function modifyResponse($response){
        $content = $response->getContent();
        $pos = strripos($content, '</body>');
        $renderedContent = $this->render();
        if (false !== $pos) {
            $content = substr($content, 0, $pos) . $renderedContent . substr($content, $pos);
        }else{
            $content = $content . $renderedContent;
        }

        $response->setContent($content);
    }

    public function render($value='')
    {
        return \View::make("translations-debugger::javascript");
    }


}
