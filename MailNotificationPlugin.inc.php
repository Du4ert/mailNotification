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


	public function getActions($request, $actionArgs)
	{
		// Get the existing actions
		$actions = parent::getActions($request, $actionArgs);
		if (!$this->getEnabled())
		{
			return $actions;
		}

		// Create a LinkAction that will call the plugin's
		// 'manage' method with the 'settings' verb
		$router = $request->getRouter();
		import('lib.pkp.classes.linkAction.request.AjaxModal');
		$linkAction = new LinkAction(
			'settings',
			new AjaxModal(
				$router->url(
					$request,
					null,
					null,
					'manage',
					null,
					[
						'verb' => 'settings',
						'plugin' => $this->getName(),
						'category' => 'generic'
					]
				),
				$this->getDisplayName()
			),
			__('manager.plugins.settings'),
			null
		);

		// Add the LinkAction to the existing actions.
    	// Make it the first action to be consistent with
		// other plugins.
		array_unshift($actions, $linkAction);

		return $actions;
	}

	public function manage($args, $request)
	{
		switch ($request->getUserVar('verb'))
		{
			// Return a JSON response containing the
			// settings form
			case 'settings':
				$templateMgr = TemplateManager::getManager($request);
				$settingsForm = $templateMgr->fetch($this->getTemplateResource('settings.tpl'));
				return new JSONMessage(true, $settingsForm);
		}
		return parent::manage($args, $request);
	}
}