<?php
import('lib.pkp.classes.plugins.BlockPlugin');
class MailNotificationBlockPlugin extends BlockPlugin {


    /**
     * Provide a name for this plugin
     *
     * The name will appear in the plugins list where editors can
     * enable and disable plugins.
     */
    public function getDisplayName() {
        return 'Mail notification block title';
    }

    /**
     * Provide a description for this plugin
     *
     * The description will appear in the plugins list where editors can
     * enable and disable plugins.
     */
    public function getDescription() {
        return 'Mail notification block description';
    }

    public function getContents($templateMgr, $request = null) {
		// $templateMgr->display($this->getTemplateResource('mailForm.tpl'));
        $templateMgr->assign([
            'content' => 'Переменная content из MailNotificationBlockPlugin.inc.php',
            'var2' => 'Custom variable'
            ]);
        return parent::getContents($templateMgr, $request);
    }
}