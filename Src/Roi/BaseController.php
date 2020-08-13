<?php


namespace Roi;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class BaseController
{
    protected $twigEnv;

    public function __construct()
    {
        $this->twigEnv = new Environment(new FilesystemLoader(env('templates.dir')), [
            'cache' => env('templates.cache'), // Cache directory
            'debug' => env('app.debug')
        ]);
        $this->addTwigFunctions();
    }

    public function render($name, $context = array())
    {
        return $this->twigEnv->render($name.env('templates.extension', '.twig'), $context);
    }

    /**
     * WIP
     */
    public function addTwigFunctions()
    {
        $registerThese = env('templates.twig_extensions');

        // Addable extensions: TokenParser, NodeVisitor, Function, Filter, Test, Operator
        $extensions = [
            'TokenParser', 'NodeVisitor', 'Function', 'Filter', 'Test', 'Operator'
        ];

        foreach ($registerThese as $type => $namespaceClass) {
            if (!in_array($type, $extensions)) {
                throw new \Error("The type(${type}) for the twig extensions does not exist");
            }

            $twigGetExtensions = 'get' . $type . 's';
            $twigAddExtension = 'add' . $type;

            // Create a new instance
            $instance = new $namespaceClass();
            $twigExtensions = $instance->$twigGetExtensions();

            // Add the extension to the Twig environment
            foreach ($twigExtensions as $twigExtension) {
                $this->twigEnv->$twigAddExtension($twigExtension);
            }
        }
    }

}
