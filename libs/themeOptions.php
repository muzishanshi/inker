<?php
/**
 * Inker For Typecho 主题设置
 */
class themeOptions {
	public function getThemeOptions(){
		static $themeOption = "";
		if ($themeOption == "") {
			$db = Typecho_Db::get();
			$queryTheme= $db->select('value')->from('table.options')->where('name = ?', 'theme'); 
			$rowTheme = $db->fetchRow($queryTheme);
			$query = $db->select('value')->from('table.options')->where('name = ?', 'theme:'.$rowTheme["value"]);
			$result = $db->fetchAll($query);
			$themeOption = unserialize($result[0]["value"]);
			unset($db);
		}
		return $themeOption;
	}

    public function checkbox($name, $options, $type, $extra = "") {
        echo '
        <div class="mdui-panel" mdui-panel>
          <div class="mdui-panel-item">
            <div class="mdui-panel-item-header">'.$name.'</div>
            <div class="mdui-panel-item-body">';
            $userOptions = $this->getThemeOptions()[$type];
            echo '<ul style="list-style: none!important">';
            foreach ($options as $option => $describe) {
                $check = "";
                if ($userOptions&&in_array($option, $userOptions)) $check = "checked";
                echo '<li>
                <label class="mdui-checkbox">
                    <input type="checkbox" name="' . $type . '[]" value="' . $option . '" ' . $check . '/>
                    <i class="mdui-checkbox-icon"></i>
                    ' . $describe . '
                </label>
                </li>';
            }
        echo ($extra !== "") ? "<br>" . $extra : "";
        echo '</ul></div></div></div>';
    }

    public function radio($name, $options, $type, $extra = "") {
        echo '
        <div class="mdui-panel" mdui-panel>
          <div class="mdui-panel-item">
            <div class="mdui-panel-item-header">'.$name.'</div>
            <div class="mdui-panel-item-body">';
            $userOption = $this->getThemeOptions()[$type];
            echo '<ul style="list-style: none!important">';
            foreach ($options as $option => $describe) {
                $check = "";
                if ($option == $userOption) $check = "checked";
                echo '<li>
                <label class="mdui-radio">
                    <input type="radio" name="' . $type . '" value="' . $option . '" ' . $check . '/>
                    <i class="mdui-radio-icon"></i>
                    ' . $describe . '
                </label>
                </li>';
            }
        echo ($extra !== "") ? "<br>" . $extra : "";
        echo '</ul></div></div></div>';
    }

    public function input($name, $type, $extra = "") {
        echo '
        <div class="mdui-panel" mdui-panel>
          <div class="mdui-panel-item">
            <div class="mdui-panel-item-header">'.$name.'</div>
            <div class="mdui-panel-item-body">';
            $userOption = $this->getThemeOptions()[$type];
            echo '<ul style="list-style: none!important">';
            echo '<div class="mdui-textfield">
            <label class="mdui-textfield-label">' . $name .'</label>
            <input class="mdui-textfield-input" type="text" name="' . $type . '" value="' . htmlspecialchars($userOption) . '"/>
          </div>';
        echo ($extra !== "") ? "<br>" . $extra : "";
        echo '</ul></div></div></div>';
    }

    public function multiInput($name, $types, $extra = "") {
        echo '
        <div class="mdui-panel" mdui-panel>
          <div class="mdui-panel-item">
            <div class="mdui-panel-item-header">'.$name.'</div>
            <div class="mdui-panel-item-body">';
            $userOptions = $this->getThemeOptions();
            echo '<ul style="list-style: none!important">';
            foreach ($types as $type => $describe) {
                echo '<div class="mdui-textfield">
                <label class="mdui-textfield-label">' . $describe .'</label>
                <input class="mdui-textfield-input" type="text" name="' . $type . '" value="' . htmlspecialchars($userOptions[$type]) . '"/>
              </div>';
            }
        echo ($extra !== "") ? "<br>" . $extra : "";
        echo '</ul></div></div></div>';
    }

    public function textarea($name, $type, $extra = "") {
        echo '
        <div class="mdui-panel" mdui-panel>
          <div class="mdui-panel-item">
            <div class="mdui-panel-item-header">'.$name.'</div>
            <div class="mdui-panel-item-body">';
            $userOption = $this->getThemeOptions()[$type];
            echo '<ul style="list-style: none!important">';
            echo '<div class="mdui-textfield">
            <label class="mdui-textfield-label">' . $name .'</label>
            <textarea class="mdui-textfield-input" type="text" name="' . $type . '"/>' . $userOption . '</textarea>
          </div>';
        echo ($extra !== "") ? "<br>" . $extra : "";
        echo '</ul></div></div></div>';
    }

    public function printThemeOptions() {
        echo "<pre>";
        print_r($this->getThemeOptions());
        echo "</pre>";
    }
}