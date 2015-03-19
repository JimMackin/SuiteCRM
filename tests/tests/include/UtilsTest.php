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
class UtilsTest extends PHPUnit_Framework_TestCase
{


    public function testmake_sugar_config()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_sugar_config_defaults()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testload_menu()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_notify_template_file()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testsugar_config_union()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testmake_not_writable()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testreturn_name()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_languages()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_all_languages()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_language_display()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_assigned_user_name()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_user_name()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_user_array()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetUserArrayFromFullName()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testshowFullName()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testclean()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testsafe_map()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testsafe_map_named()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testreturn_app_list_strings_language()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function test_mergeCustomAppListStrings()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testreturn_application_language()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testreturn_module_language()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testreturn_mod_list_strings_language()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testreturn_theme_language()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testreturn_session_value_or_default()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testappend_where_clause()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgenerate_where_statement()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function is_guidProvider()
    {
        return array(
            array('abcdefgh-ijkl-mnop-qrst-uvwxyz012345',true),
            array('',false),
            array('f',false),
            array('abcdefgh-ijkl-mnop-qrst-uvwxyz01234567',false),
        );
    }
    /**
     * @dataProvider is_guidProvider
     */
    public function testis_guid($guid, $expected)
    {
        $this->assertSame($expected, is_guid($guid));
    }

    public function testcreate_guid()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testcreate_guid_section()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function ensure_lengthProvider()
    {
        return array(
            array('FooBarBaz',5, 'FooBa'),
            array('FooBarBaz',0,''),
            array('',4,'0000'),
            array('1234', 6, '123400'),
        );
    }
    /**
     * @dataProvider ensure_lengthProvider
     */
    public function testensure_length($str, $len, $expected)
    {
        ensure_length($str,$len);
        $this->assertSame($expected,$str);
    }
    public function microtime_diffProvider()
    {
        return array(
            array('0.16612700 1426762074', '0.16612700 1426762074', 0.0),
            array('0.16612700 1426762074', '0.59010800 1426762117', 43.423980999999998),
            array('0.59010800 1426762117', '0.16612700 1426762074', -43.423980999999998),
            array('0.16612700 1426762074', '"0.90462900 1426762234', 159.83387300000001),
        );
    }
    /**
     * @dataProvider microtime_diffProvider
     */
    public function testmicrotime_diff($a, $b, $expected)
    {
        $this->assertSame($expected,microtime_diff($a,$b));
    }

    public function testdisplayStudioForCurrentUser()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testdisplayWorkflowForCurrentUser()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_admin_modules_for_user()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_workflow_admin_modules_for_user()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testis_admin_for_any_module()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testis_admin_for_module()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testis_admin()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_theme_display()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_themes()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_select_options()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_select_options_with_id()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_select_options_with_id_separate_key()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testsugar_die()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_clear_form_js()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_set_focus_js()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testarray_csort()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testparse_calendardate()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testtranslate()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testunTranslateNum()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testadd_http()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetDefaultXssTags()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testremove_xss()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testclean_xss()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testxss_check_pattern()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testclean_string()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testclean_special_arguments()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testclean_superglobals()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testset_superglobals()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testclean_incoming_data()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function teststr_beginProvider()
    {
        return array(
            array('FooBarBaz','Foo',true),
            array('FooBarBaz','Biz',false),
            array('','',true),
            array('','Biz',false),
            array('Foo','',true),
        );
    }
    /**
     * @dataProvider teststr_beginProvider
     */
    public function teststr_begin($str, $begin, $expected)
    {
        $this->assertSame($expected,str_begin($str, $begin));
    }

    public function teststr_endProvider()
    {
        return array(
            array('FooBarBaz','Baz',true),
            array('FooBarBaz','Biz',false),
            array('','',true),
            array('','Biz',false),
            array('Foo','',true),
        );
    }
    /**
     * @dataProvider teststr_endProvider
     */
    public function teststr_end($str, $end, $expected)
    {
        $this->assertSame($expected,str_end($str, $end));
    }

    public function testsecurexss()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testsecurexsskey()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testpreprocess_param()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testcleanup_slashes()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testset_register_value()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_register_value()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testclear_register_value()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testconvert_id()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_image()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetImagePath()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetWebPath()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetVersionedPath()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetVersionedScript()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetJSPath()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetSWFPath()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetSQLDate()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testclone_history()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testvalues_to_keysProvider()
    {
        return array(
            array(array('Foo','Bar','Baz'),array('Foo'=>'Foo','Bar'=>'Bar','Baz'=>'Baz')),
            array(array('Foo'=>'Bar','Baz'=>'Biz'),array('Bar'=>'Bar','Biz'=>'Biz')),
            array(array('1'=>1),array(1=>1)),
            array('Foo',array()),
        );
    }
    /**
     * @dataProvider testvalues_to_keysProvider
     */
    public function testvalues_to_keys($arr, $expected)
    {
        $this->assertSame($expected,values_to_keys($arr));
    }

    public function testclone_relationship()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_unlinked_email_query()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_emails_by_assign_or_link()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testnumberProvider()
    {
        return array(
            array('0',false),
            array('',true),
            array(false,false),
            array('100',false),
        );
    }
    /**
     * @dataProvider testnumberProvider
     */
    public function testnumber_empty($value, $expected)
    {
        $this->assertSame($expected, number_empty($value));
    }

    public function testget_bean_select_array()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testparse_list_modules()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testdisplay_notice()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testskype_formatted()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testformat_skype()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testinsert_charset_header()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetCurrentURL()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testjavascript_escape()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testjs_escape()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function br2nlProvider()
    {
        return array(
            array('',''),
            array('<br>',"\n"),
            array('<br ><br>',"\n\n"),
            array('<br/>',"\n"),
            array('<br />',"\n"),
            array('<br  />',"\n"),
            array('Foo<br>',"Foo\n"),
            array("\n<br>","\n\n"),
        );
    }
    /**
     * @dataProvider br2nlProvider
     */
    public function testbr2nl($str, $expected)
    {
        $this->assertSame($expected,br2nl($str));
    }


    public function test_ppl()
    {
        $this->markTestIncomplete('Not implemented yet');
    }



    public function testcheck_php_version()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testcheck_iis_version()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testpre_login_check()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testsugar_cleanup()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testcheck_logic_hook_file()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testremove_logic_hook()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testdisplay_stack_trace()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testStackTraceErrorHandler()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_sub_cookies()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testmark_delete_components()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testreturn_bytes()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testurl2html()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testis_windows()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testis_writable_windows()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testlookupTimezone()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testconvert_module_to_singular()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_singular_bean_name()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_module_from_singular()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_label()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testsearch_filter_rel_info()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_module_info()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_valid_bean_name()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testcheckAuthUserStatus()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetPhpInfo()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function teststring_format()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testformat_number_display()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testcheckLoginUserStatus()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function appendPortToHostProvider()
    {
        return array(
            array('','',''),
            array('www.suitecrm.com','80','www.suitecrm.com:80'),
            array('www.suitecrm.com','467','www.suitecrm.com:467'),
            array('www.suitecrm.com','Foo','www.suitecrm.com:Foo'),
            array('http://www.suitecrm.com','123','http://www.suitecrm.com:123'),
            array('https://www.suitecrm.com','123','https://www.suitecrm.com:123'),
            array('ftp://www.suitecrm.com','123','ftp://www.suitecrm.com:123'),
            array('http://www.suitecrm.com/foo/bar/','123','http://www.suitecrm.com:123/foo/bar/'),
            array('https://www.suitecrm.com/foo/bar/','123','https://www.suitecrm.com:123/foo/bar/'),
            array('ftp://www.suitecrm.com/foo/bar/','123','ftp://www.suitecrm.com:123/foo/bar/'),
            array('http://www.suitecrm.com/foo/bar/index.php','123','http://www.suitecrm.com:123/foo/bar/index.php'),
            array('https://www.suitecrm.com/foo/bar/index.php','123','https://www.suitecrm.com:123/foo/bar/index.php'),
            array('ftp://www.suitecrm.com/foo/bar/index.php','123','ftp://www.suitecrm.com:123/foo/bar/index.php'),
        );
    }
    /**
     * @dataProvider appendPortToHostProvider
     */
    public function testappendPortToHost($host,$port,$expected)
    {
        $this->assertSame($expected,appendPortToHost($host,$port));
    }

    public function testgetJSONobj()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testsetPhpIniSettings()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testsugarLangArrayMerge()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testsugarArrayMerge()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testsugarArrayMergeRecursive()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testreturnPhpJsonStatus()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetTrackerSubstring()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgenerate_search_where()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function add_quotesProvider()
    {
        return array(
            array('',"''"),
            array('foo',"'foo'"),
            array('≣',"'≣'"),
        );
    }
    /**
     * @dataProvider add_quotesProvider
     */
    public function testadd_quotes($str, $expected)
    {
        //TODO: Identical to add_squotes. Replace one of these.
        $this->assertSame($expected, add_squotes($str));
    }

    public function testrebuildConfigFile()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testloadCleanConfig()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetJavascriptSiteURL()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function add_squotesProvider()
    {
        return array(
            array('',"''"),
            array('foo',"'foo'"),
            array('≣',"'≣'"),
        );
    }
    /**
     * @dataProvider add_squotesProvider
     */
    public function testadd_squotes($str, $expected)
    {
        $this->assertSame($expected, add_squotes($str));
    }

    public function testarray_depth()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testcreateGroupUser()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function test_getIcon()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetStudioIcon()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_dashlets_dialog_icon()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testhtml_entity_decode_utf8()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testcode2utf()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function teststr_split_php4()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function teststr_split()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testis_freetds()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testchartStyle()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testchartColors()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testajaxInit()
    {
        $this->assertNotFalse(ini_get('display_errors'));
        ajaxInit();
        $this->assertFalse(ini_get('display_errors'));
        ini_set('display_errors',1);
    }

    public function testgetAbsolutePath()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testloadBean()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testisTouchScreen()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_alt_hot_key()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testcan_start_session()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testload_link_class()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testinDeveloperMode()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testfilterInboundEmailPopSelection()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testsugar_substr()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function sugar_ucfirstProvider()
    {
        return array(
            array('',''),
            array('foo','Foo'),
            array('≣','≣'),
            array('foo≣','Foo≣'),
            array('≣foo','≣foo'),
        );
    }
    /**
     * @dataProvider sugar_ucfirstProvider
     */
    public function testsugar_ucfirst($str, $expected)
    {
        $this->assertSame($expected,sugar_ucfirst($str));
    }

    public function unencodeMultienumProvider()
    {
        return array(
            array('',array('')),
            array('Foo',array('Foo')),
            array('^Foo^',array('Foo')),
            array('^Foo^,^Bar^,^Baz^',array('Foo','Bar','Baz')),
            array('^Foo^,^Bar^,Baz^',array('Foo','Bar^,Baz')),

        );
    }
    /**
     * @dataProvider unencodeMultienumProvider
     */
    public function testunencodeMultienum($string, $expected)
    {
        $this->assertSame($expected,unencodeMultienum($string));
    }
    public function encodeMultienumValueProvider()
    {
        return array(
            array(array(''),'^^'),
            array(array('Foo'),'^Foo^'),
            array(array('Foo','Bar','Baz'),'^Foo^,^Bar^,^Baz^'),
            array(array('Foo','Bar^,Baz'),'^Foo^,^Bar^,Baz^'),

        );
    }
    /**
     * @dataProvider encodeMultienumValueProvider
     */
    public function testencodeMultienumValue($arr, $expected)
    {
        $this->assertSame($expected,encodeMultienumValue($arr));
    }

    public function testcreate_export_query_relate_link_patch()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testclearAllJsAndJsLangFilesWithoutOutput()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetVariableFromQueryString()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testshould_hide_iframes()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetVersionStatus()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetMajorMinorVersion()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testsugar_microtime()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetUrls()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testverify_image_file()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testverify_uploaded_image()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testcmp_beans()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function order_beansProvider()
    {
        $bean1 = $this->getMock('Accounts');
        $bean1->id = 'aa';
        $bean2 = $this->getMock('Accounts');
        $bean2->id = 'aa';
        $bean3 = $this->getMock('Accounts');
        $bean3->id = 'a1';
        $bean4 = $this->getMock('Accounts');
        $bean4->id = 'ba';
        $bean5 = $this->getMock('Accounts');
        $bean5->id = '12';
        $bean6 = $this->getMock('Accounts');
        $bean6->id = '22';
        return array(
            array(array($bean1,$bean2,$bean3,$bean4,$bean5,$bean6),'id'),
            array(array($bean6,$bean5,$bean4,$bean3,$bean2,$bean1),'id'),
        );
    }
    /**
     * @dataProvider order_beansProvider
     */
    public function testorder_beans($beanArr,$field)
    {
        $beanArr = order_beans($beanArr,$field);
        $current = '';
        foreach($beanArr as $bean){
            if(!$current){
                $current = $bean->$field;
            }else{
                $this->assertGreaterThan($current,$bean->$field);
            }
        }
    }

    public function testsql_like_string()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function sanitizeProvider()
    {
        return array(
            array('','','',''),
            array('','','',''),
        );
    }
    /**
     * @dataProvider sanitizeProvider
     */
    public function testsanitize($input, $quotes, $charset, $remove)
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetFTSEngineType()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetFTSBoostOptions()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testutf8_recursive_encode()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_language_header()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_custom_file_if_exists()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_help_url()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgenerateETagHeader()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetReportNameTranslation()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function clean_sensitive_dataProvider()
    {
        $def = array(
            'foo' => array(),
            'bar' => array('sensitive'=> 1),
            'baz' => array('sensitive'=> 0),
        );

        $data = array('foo'=>'foo','bar'=>'bar','baz'=>'baz');
        $bean = $this->getMock('Accounts');
        return array(
            array($def, $data),
            array($def, $bean),
        );
    }
    /**
     * @dataProvider clean_sensitive_dataProvider
     */
    public function testclean_sensitive_data($def, $data)
    {
        $cleaned = clean_sensitive_data($def,$data);
        foreach($def as $field => $fieldDef){
            if(!empty($fieldDef['sensitive'])){
                if(is_array($data)){
                    $this->assertEmpty($cleaned[$field]);
                }
                if($data instanceof SugarBean) {
                    $this->assertEmpty($cleaned->$field);
                }
            }else{
                if(is_array($data)){
                    $this->assertNotEmpty($cleaned[$field]);
                }
                if($data instanceof SugarBean) {
                    $this->assertNotEmpty($cleaned->$field);
                }
            }
        }
    }

    public function testgetDuplicateRelationListWithTitle()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetTypeDisplayList()
    {
        $this->assertSame(array('record_type_display', 'parent_type_display', 'record_type_display_notes'), getTypeDisplayList());
    }

    public function testassignConcatenatedValue()
    {
        $this->markTestIncomplete('Not implemented yet');
    }
}