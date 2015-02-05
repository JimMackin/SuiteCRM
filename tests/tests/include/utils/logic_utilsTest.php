<?php
/**
 *
 *
 * @package
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author Salesagility Ltd <support@salesagility.com>
 */
require_once 'include/utils/logic_utils.php';
class logic_utilsTest extends PHPUnit_Framework_TestCase
{


    private function getTestHook(){
        $hook_array = Array();
        $hook_array['after_ui_footer'] = Array();
        $hook_array['after_ui_footer'][] = Array(10, 'popup_onload', 'modules/SecurityGroups/AssignGroups.php','AssignGroups', 'popup_onload');
        $hook_array['after_ui_frame'] = Array();
        $hook_array['after_ui_frame'][] = Array(20, 'mass_assign', 'modules/SecurityGroups/AssignGroups.php','AssignGroups', 'mass_assign');
        $hook_array['after_ui_frame'][] = Array(1, 'Load Social JS', 'custom/include/social/hooks.php','hooks', 'load_js');
        $hook_array['after_save'] = Array();
        $hook_array['after_save'][] = Array(30, 'popup_select', 'modules/SecurityGroups/AssignGroups.php','AssignGroups', 'popup_select');
        $hook_array['after_save'][] = Array(1, 'AOD Index Changes', 'modules/AOD_Index/AOD_LogicHooks.php','AOD_LogicHooks', 'saveModuleChanges');
        $hook_array['after_delete'] = array();
        $hook_array['after_delete'][] = Array(1, 'AOD Index changes', 'modules/AOD_Index/AOD_LogicHooks.php','AOD_LogicHooks', 'saveModuleDelete');
        $hook_array['after_restore'] = array();
        $hook_array['after_restore'][] = Array(1, 'AOD Index changes', 'modules/AOD_Index/AOD_LogicHooks.php','AOD_LogicHooks', 'saveModuleRestore');
        return $hook_array;
    }

    public function check_existing_elementProvider()
    {
        $hook_array = $this->getTestHook();
        return array(
            array($hook_array,'after_save',array(0,'popup_select'), true),
            array($hook_array,'after_save',array(0,'foo'), false),
            array($hook_array,'foo',array(0,'popup_select'), false),
        );
    }

    /**
     * @dataProvider check_existing_elementProvider
     */
    function testcheck_existing_element($hook_array, $event, $action_array, $expected){
        $this->assertSame($expected, check_existing_element($hook_array, $event, $action_array));
    }

    function testreplace_or_add_logic_type(){
        $hook_array = $this->getTestHook();
        $expected = "<?php\n// Do not store anything in this file that is not part of the array or the hook version.  This file will	\n// be automatically rebuilt in the future. \n \$hook_version = 1; \n\$hook_array = Array(); \n// position, file, function \n\$hook_array['after_ui_footer'] = Array(); \n\$hook_array['after_ui_footer'][] = Array(10, 'popup_onload', 'modules/SecurityGroups/AssignGroups.php','AssignGroups', 'popup_onload'); \n\$hook_array['after_ui_frame'] = Array(); \n\$hook_array['after_ui_frame'][] = Array(20, 'mass_assign', 'modules/SecurityGroups/AssignGroups.php','AssignGroups', 'mass_assign'); \n\$hook_array['after_ui_frame'][] = Array(1, 'Load Social JS', 'custom/include/social/hooks.php','hooks', 'load_js'); \n\$hook_array['after_save'] = Array(); \n\$hook_array['after_save'][] = Array(30, 'popup_select', 'modules/SecurityGroups/AssignGroups.php','AssignGroups', 'popup_select'); \n\$hook_array['after_save'][] = Array(1, 'AOD Index Changes', 'modules/AOD_Index/AOD_LogicHooks.php','AOD_LogicHooks', 'saveModuleChanges'); \n\$hook_array['after_delete'] = Array(); \n\$hook_array['after_delete'][] = Array(1, 'AOD Index changes', 'modules/AOD_Index/AOD_LogicHooks.php','AOD_LogicHooks', 'saveModuleDelete'); \n\$hook_array['after_restore'] = Array(); \n\$hook_array['after_restore'][] = Array(1, 'AOD Index changes', 'modules/AOD_Index/AOD_LogicHooks.php','AOD_LogicHooks', 'saveModuleRestore'); \n\n\n\n?>";
        $this->assertEquals($expected,replace_or_add_logic_type($hook_array));
    }

    function testwrite_logic_file_and_get_hook_array(){
        //TODO: Refactor write_logic_file so we can use vfsStream for testing rather than directly accessing the filesystem.
        if (file_exists('custom/modules/TEST_Test')) {
            unlink('custom/modules/TEST_Test/logic_hooks.php');
            rmdir('custom/modules/TEST_Test');
        }
        $expectedContents = "<?php\n// Do not store anything in this file that is not part of the array or the hook version.  This file will	\n// be automatically rebuilt in the future. \n \$hook_version = 1; \n\$hook_array = Array(); \n// position, file, function \n\$hook_array['after_ui_footer'] = Array(); \n\$hook_array['after_ui_footer'][] = Array(10, 'popup_onload', 'modules/SecurityGroups/AssignGroups.php','AssignGroups', 'popup_onload'); \n\$hook_array['after_ui_frame'] = Array(); \n\$hook_array['after_ui_frame'][] = Array(20, 'mass_assign', 'modules/SecurityGroups/AssignGroups.php','AssignGroups', 'mass_assign'); \n\$hook_array['after_ui_frame'][] = Array(1, 'Load Social JS', 'custom/include/social/hooks.php','hooks', 'load_js'); \n\$hook_array['after_save'] = Array(); \n\$hook_array['after_save'][] = Array(30, 'popup_select', 'modules/SecurityGroups/AssignGroups.php','AssignGroups', 'popup_select'); \n\$hook_array['after_save'][] = Array(1, 'AOD Index Changes', 'modules/AOD_Index/AOD_LogicHooks.php','AOD_LogicHooks', 'saveModuleChanges'); \n\$hook_array['after_delete'] = Array(); \n\$hook_array['after_delete'][] = Array(1, 'AOD Index changes', 'modules/AOD_Index/AOD_LogicHooks.php','AOD_LogicHooks', 'saveModuleDelete'); \n\$hook_array['after_restore'] = Array(); \n\$hook_array['after_restore'][] = Array(1, 'AOD Index changes', 'modules/AOD_Index/AOD_LogicHooks.php','AOD_LogicHooks', 'saveModuleRestore'); \n\n\n\n?>";
        write_logic_file('TEST_Test',$expectedContents);
        //Check file created
        $this->assertFileExists('custom/modules/TEST_Test/logic_hooks.php');
        $actualContents = file_get_contents('custom/modules/TEST_Test/logic_hooks.php');
        $this->assertSame($expectedContents, $actualContents);

        $expectedArray = $this->getTestHook();

        $actualArray = get_hook_array('TEST_Test');

        $this->assertSame($expectedArray, $actualArray);

        unlink('custom/modules/TEST_Test/logic_hooks.php');
        rmdir('custom/modules/TEST_Test');
    }


    function testbuild_logic_file(){
        $hook_array = $this->getTestHook();
        $expected = "// Do not store anything in this file that is not part of the array or the hook version.  This file will	\n// be automatically rebuilt in the future. \n \$hook_version = 1; \n\$hook_array = Array(); \n// position, file, function \n\$hook_array['after_ui_footer'] = Array(); \n\$hook_array['after_ui_footer'][] = Array(10, 'popup_onload', 'modules/SecurityGroups/AssignGroups.php','AssignGroups', 'popup_onload'); \n\$hook_array['after_ui_frame'] = Array(); \n\$hook_array['after_ui_frame'][] = Array(20, 'mass_assign', 'modules/SecurityGroups/AssignGroups.php','AssignGroups', 'mass_assign'); \n\$hook_array['after_ui_frame'][] = Array(1, 'Load Social JS', 'custom/include/social/hooks.php','hooks', 'load_js'); \n\$hook_array['after_save'] = Array(); \n\$hook_array['after_save'][] = Array(30, 'popup_select', 'modules/SecurityGroups/AssignGroups.php','AssignGroups', 'popup_select'); \n\$hook_array['after_save'][] = Array(1, 'AOD Index Changes', 'modules/AOD_Index/AOD_LogicHooks.php','AOD_LogicHooks', 'saveModuleChanges'); \n\$hook_array['after_delete'] = Array(); \n\$hook_array['after_delete'][] = Array(1, 'AOD Index changes', 'modules/AOD_Index/AOD_LogicHooks.php','AOD_LogicHooks', 'saveModuleDelete'); \n\$hook_array['after_restore'] = Array(); \n\$hook_array['after_restore'][] = Array(1, 'AOD Index changes', 'modules/AOD_Index/AOD_LogicHooks.php','AOD_LogicHooks', 'saveModuleRestore'); \n\n\n";
        $this->assertEquals($expected,build_logic_file($hook_array));
    }
}
