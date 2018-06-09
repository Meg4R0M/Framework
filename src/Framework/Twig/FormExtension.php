<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 09/06/18
 * Time: 12:37
 */

namespace App\Framework\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class FormExtension
 * @package App\Framework\Twig
 */
class FormExtension extends Twig_Extension
{

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new Twig_SimpleFunction('field', [$this, 'field'], [
                'is_safe' => ['html'],
                'needs_context' => true
            ])
        ];
    }

    /**
     * Génére le code HTML d'un champs
     *
     * @param array $context
     * @param string $key
     * @param $value
     * @param string $label
     * @param array $options
     * @return string
     */
    public function field(array $context, string $key, $value, ?string $label = null, array $options = []): string
    {
        $type = $options['type'] ?? 'text';
        $error = $this->getErrorHTML($context, $key);
        $class = 'form-group';
        $value = $this->convertValue($value);
        $attributes = [
            'class' => trim('form-control ' . ($options['class'] ?? '')),
            'name'  => $key,
            'id'    => $key
        ];

        if ($error) {
            $class .= ' has-danger';
            $attributes['class'] .= ' form-control-danger';
        }
        if ($type === 'textarea') {
            $input = $this->textarea($value, $attributes);
        } else {
            $input = $this->input($value, $attributes);
        }
        return "<div class=\"" . $class . "\">
                <label for=\"name\">{$label}</label>
                {$input}
                {$error}
            </div>";
    }

    /**
     * Génére l'HTML en fonction des erreurs du contexte
     *
     * @param $context
     * @param $key
     * @return string
     */
    private function getErrorHTML($context, $key)
    {
        $error = $context['errors'][$key] ?? false;
        if ($error) {
            return "<small class=\"form-text text-muted\">{$error}</small>";
        }
        return "";
    }

    /**
     * Génére un <input>
     *
     * @param null|string $value
     * @param array $attributes
     * @return string
     */
    private function input(?string $value, array $attributes): string
    {
        return "<input type=\"text\" " . $this->getHtmlFromArray($attributes) . " value=\"{$value}\">";
    }

    /**
     * Génére un <textarea>
     *
     * @param null|string $value
     * @param array $attributes
     * @return string
     */
    private function textarea(?string $value, array $attributes): string
    {
        return "<textarea " . $this->getHtmlFromArray($attributes) . " rows=\"10\">{$value}</textarea>";
    }

    /**
     * Transforme un tableau $clef => $valeur en attribut HTML
     *
     * @param array $attributes
     * @return string
     */
    private function getHtmlFromArray(array $attributes)
    {
        return implode(' ', array_map(function ($key, $value) {
            return "$key=\"$value\"";
        }, array_keys($attributes), $attributes));
    }

    private function convertValue($value): string
    {
        if ($value instanceof \DateTime) {
            return $value->format('Y-m-d H:i:s');
        }
        return (string)$value;
    }
}
