<?php
namespace Abyss\Pages;

abstract class Page {
	public abstract function getTemplate();
	public abstract function getTemplatePath();
}