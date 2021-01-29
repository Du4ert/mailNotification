<?php
import('lib.pkp.classes.plugins.GenericPlugin');


class MailNotificationPlugin extends GenericPlugin
{
	/**
	 * @return string plugin name
	 */
	public function getDisplayName()
	{
		return __('plugins.generic.mailNotification.title');
	}

	/**
	 * @return string plugin description
	 */
	public function getDescription()
	{
		return __('plugins.generic.mailNotification.desc');
	}


	public function register($category, $path, $mainContextId = NULL)
	{
		$success = parent::register($category, $path);

		if ($success && $this->getEnabled()) {
			// Do something when the plugin is enabled
			$this->import('MailNotificationBlockPlugin');
			PluginRegistry::register('blocks', new MailNotificationBlockPlugin($this), $this->getPluginPath());
		}

		return $success;
	}
}