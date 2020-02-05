<?php

namespace ls\tests;

use LimeSurvey\Models\Services\QuestionThemeConverter;
use LimeSurvey\Models\Services\XmlIO;
use Yii;

/**
 * Check the JSON saved in database.
 */
class QuestionThemeConverterTest extends TestBaseClass
{
    /** @var string Config for question theme, LS3 */
    private $dummyLS3config = <<<XML
<?xml version="1.0" encoding="UTF-8"?>

<config>
    <metadata>
        <name>List-Radio-Test-2</name>
        <type>question_theme</type>
        <title>List Radio Test 2</title>
        <creationDate>05/11/2019</creationDate>
        <author>Tony Partner</author>
        <authorEmail>tpartner@partnersurveys.com</authorEmail>
        <authorUrl>http://partnersurveys.com</authorUrl>
        <license>GNU General Public License version 2 or later</license>
        <version>1.0</version>
        <apiVersion>1</apiVersion>
        <description>A list radio test</description>
        <questionType>L</questionType>
        <group>Single choice questions</group>
        <answerscales>0</answerscales>
        <hasdefaultvalues>1</hasdefaultvalues>
        <assessable>1</assessable>
        <class>list-radio</class>
    </metadata>

    <compatibility>
        <version>4.0</version>
    </compatibility>

    <!--
        Here the list of the css/js files to load.
        Any file here will be loaded via the asset manager (when in config.php debug = 0)
    -->
    <files>
        <css>
            <filename>css/lrt.css</filename>
        </css>
        <js>
            <filename>scripts/lrt.js</filename>
        </js>
		<preview>
			<filename>images/lrt_1.png</filename>
		</preview>
    </files>

    <custom_attributes>
        <!-- New attributes -->
        <attribute>
            <name>custom_attribute_1</name>
            <category>Custom options</category>
            <sortorder>0</sortorder>
            <inputtype>buttongroup</inputtype>
            <options>
                <yes>Yes</yes>
                <no>No</no>
            </options>
            <default>no</default>
            <help>Just a test attribute...</help>
            <caption>Test attribute 1</caption>
            <readonly_when_active>false</readonly_when_active>
        </attribute>
        <attribute>
            <name>custom_attribute_2</name>
            <category>Custom options</category>
            <sortorder>1</sortorder>
            <inputtype>text</inputtype>
            <default>...</default>
            <help>A test text attribute.</help>
            <caption>Test attribute 2</caption>
            <i18n>hr</i18n>
        </attribute>
    </custom_attributes>

    <!-- Here datas about how LimeSurvey should load the core js/css of the question -->
    <engine>
        <load_core_css>true</load_core_css>
        <load_core_js>true</load_core_js>
        <show_as_template>true</show_as_template>
        <show_as_question_type>true</show_as_question_type>
    </engine>
</config>
XML;

    /** @var string Config for question theme, LS4 */
    private $dummyLS4config = <<<XML
<?xml version="1.0" encoding="UTF-8"?>

<config>
    <!-- Metadata -->
    <metadata>
        <name>listradio</name>
        <type>question_theme</type>
        <title>List (Radio)</title>
        <creationDate>09/08/2018</creationDate>
        <author>Dominik Vitt</author>
        <authorEmail>dominik.vitt@limesurvey.org</authorEmail>
        <authorUrl>http://www.limesurvey.org</authorUrl>
        <copyright>Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.</copyright>
        <license>GNU General Public License version 2 or later</license>
        <version>1.0</version>
        <apiVersion>1</apiVersion>
        <description>List (radio) question type configuration</description>
        <questionType>L</questionType>
        <group>Single choice questions</group>
        <subquestions>0</subquestions>
        <answerscales>1</answerscales>
        <hasdefaultvalues>1</hasdefaultvalues>
        <assessable>1</assessable>
        <class>list-radio</class>
    </metadata>

    <compatibility>
        <version>4.0</version>
    </compatibility>

    <!--
        List of the css/js files to load.
        Any file here will be loaded via the asset manager (when in config.php debug = 0)
    -->
    <files>
        <css>
            <filename></filename>
        </css>
        <js>
            <filename></filename>
        </js>
        <preview>
            <filename></filename>
        </preview>
    </files>

    <generalattributes>
        <attribute>question_template</attribute>
        <attribute>gid</attribute>
        <attribute>other</attribute>
        <attribute>mandatory</attribute>
        <attribute>relevance</attribute>
        <attribute>encrypted</attribute>
        <attribute>save_as_default</attribute>
        <attribute>clear_default</attribute>
        <attribute>preg</attribute>
    </generalattributes>

    <!-- Question attributes -->
    <attributes>
        <!-- Display Attributes START -->
        <attribute>
            <name>alphasort</name>
            <category>Display</category>
            <sortorder>100</sortorder>
            <inputtype>switch</inputtype>
            <options>
                <option>
                    <value>0</value>
                    <text>No</text>
                </option>
                <option>
                    <value>1</value>
                    <text>Yes</text>
                </option>
            </options>
            <default>0</default>
            <help>Sort the answer options alphabetically</help>
            <caption>Sort answers alphabetically</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>random_order</name>
            <category>Display</category>
            <sortorder>100</sortorder>
            <inputtype>singleselect</inputtype>
            <options>
                <option>
                    <value>0</value>
                    <text>No</text>
                </option>
                <option>
                    <value>1</value>
                    <text>Yes</text>
                </option>
            </options>
            <default>0</default>
            <help>Present subquestions/answer options in random order</help>
            <caption>Random order</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>hide_tip</name>
            <category>Display</category>
            <sortorder>100</sortorder>
            <inputtype>switch</inputtype>
            <options>
                <option>
                    <value>0</value>
                    <text>No</text>
                </option>
                <option>
                    <value>1</value>
                    <text>Yes</text>
                </option>
            </options>
            <default>0</default>
            <help>Hide the tip that is normally shown with a question</help>
            <caption>Hide tip</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>hidden</name>
            <category>Display</category>
            <sortorder>101</sortorder>
            <inputtype>switch</inputtype>
            <options>
                <option>
                    <value>0</value>
                    <text>No</text>
                </option>
                <option>
                    <value>1</value>
                    <text>Yes</text>
                </option>
            </options>
            <default>0</default>
            <help>Hide this question at any time. This is useful for including data using answer prefilling.</help>
            <caption>Always hide this question</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>cssclass</name>
            <category>Display</category>
            <sortorder>102</sortorder>
            <inputtype>text</inputtype>
            <expression>1</expression>
            <help>Add additional CSS class(es) for this question. Use a space between multiple CSS class names. You
                may use expressions - remember this part is static.
            </help>
            <caption>CSS class(es)</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
        </attribute>
        <attribute>
            <name>printable_help</name>
            <category>Display</category>
            <sortorder>201</sortorder>
            <inputtype>text</inputtype>
            <expression>1</expression>
            <i18n>1</i18n>
            <default></default>
            <help>In the printable version the condition is being replaced with this explanation text.</help>
            <caption>Relevance help for printable survey</caption>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
        </attribute>
        <attribute>
            <name>display_columns</name>
            <category>Display</category>
            <sortorder>100</sortorder>
            <inputtype>columns</inputtype>
            <default></default>
            <help>The answer options will be distributed across the number of columns set here</help>
            <caption>Display columns</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <!-- Display Attributes END -->
        <!-- Logic Attributes START -->
        <attribute>
            <name>array_filter</name>
            <category>Logic</category>
            <sortorder>100</sortorder>
            <inputtype>text</inputtype>
            <help>Enter the code(s) of Multiple choice question(s) (separated by semicolons) to only show the matching answer options in this question.</help>
            <caption>Array filter</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>array_filter_style</name>
            <category>Logic</category>
            <sortorder>100</sortorder>
            <inputtype>buttongroup</inputtype>
            <options>
                <option>
                    <value>0</value>
                    <text>Hidden</text>
                </option>
                <option>
                    <value>1</value>
                    <text>Disabled</text>
                </option>
            </options>
            <default>0</default>
            <help>Specify how array-filtered sub-questions should be displayed</help>
            <caption>Array filter style</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>array_filter_exclude</name>
            <category>Logic</category>
            <sortorder>100</sortorder>
            <inputtype>text</inputtype>
            <help>Enter the code(s) of Multiple choice question(s) (separated by semicolons) to exclude the matching answer options in this question.</help>
            <caption>Array filter exclusion</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>other_numbers_only</name>
            <category>Logic</category>
            <sortorder>100</sortorder>
            <inputtype>switch</inputtype>
            <options>
                <option>
                    <value>0</value>
                    <text>No</text>
                </option>
                <option>
                    <value>1</value>
                    <text>Yes</text>
                </option>
            </options>
            <default>0</default>
            <help>Allow only numerical input for &amp;#039;Other&amp;#039; text</help>
            <caption>Numbers only for &amp;#039;Other&amp;#039;</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>random_group</name>
            <category>Logic</category>
            <sortorder>180</sortorder>
            <inputtype>text</inputtype>
            <help>Place questions into a specified randomization group, all questions included in the specified
                group will appear in a random order
            </help>
            <caption>Randomization group name</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>em_validation_q</name>
            <category>Logic</category>
            <sortorder>200</sortorder>
            <inputtype>textarea</inputtype>
            <expression>2</expression>
            <help>Enter a boolean equation to validate the whole question.</help>
            <caption>Question validation equation</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
        </attribute>
        <attribute>
            <name>other_comment_mandatory</name>
            <category>Logic</category>
            <sortorder>100</sortorder>
            <inputtype>switch</inputtype>
            <options>
                <option>
                    <value>0</value>
                    <text>No</text>
                </option>
                <option>
                    <value>1</value>
                    <text>Yes</text>
                </option>
            </options>
            <default>0</default>
            <help>Make the &amp;#039;Other:&amp;#039; comment field mandatory when the &amp;#039;Other:&amp;#039;
                option is active
            </help>
            <caption>&amp;#039;Other:&amp;#039; comment mandatory</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>em_validation_q_tip</name>
            <category>Logic</category>
            <sortorder>210</sortorder>
            <inputtype>textarea</inputtype>
            <expression>1</expression>
            <i18n>1</i18n>
            <help>This is a hint text that will be shown to the participant describing the question validation
                equation.
            </help>
            <caption>Question validation tip</caption>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
        </attribute>
        <!-- Logic Attributes END -->
        <!-- Other Attributes START -->
        <attribute>
            <name>page_break</name>
            <category>Other</category>
            <sortorder>100</sortorder>
            <inputtype>switch</inputtype>
            <options>
                <option>
                    <value>0</value>
                    <text>No</text>
                </option>
                <option>
                    <value>1</value>
                    <text>Yes</text>
                </option>
            </options>
            <default>0</default>
            <help>Insert a page break before this question in printable view by setting this to Yes.</help>
            <caption>Insert page break in printable view</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>scale_export</name>
            <category>Other</category>
            <sortorder>100</sortorder>
            <inputtype>singleselect</inputtype>
            <options>
                <option>
                    <value>0</value>
                    <text>Default</text>
                </option>
                <option>
                    <value>1</value>
                    <text>Nominal</text>
                </option>
                <option>
                    <value>2</value>
                    <text>Ordinal</text>
                </option>
                <option>
                    <value>3</value>
                    <text>Scale</text>
                </option>
            </options>
            <default>0</default>
            <help>Set a specific SPSS export scale type for this question</help>
            <caption>SPSS export scale type</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <!-- Other Attributes END -->
        <!-- Statistics Attributes START -->
        <attribute>
            <name>public_statistics</name>
            <category>Statistics</category>
            <sortorder>80</sortorder>
            <inputtype>switch</inputtype>
            <options>
                <option>
                    <value>0</value>
                    <text>No</text>
                </option>
                <option>
                    <value>1</value>
                    <text>Yes</text>
                </option>
            </options>
            <default>0</default>
            <help>Show statistics of this question in the public statistics page</help>
            <caption>Show in public statistics</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>statistics_showgraph</name>
            <category>Statistics</category>
            <inputtype>switch</inputtype>
            <sortorder>101</sortorder>
            <options>
                <option>
                    <value>1</value>
                    <text>Yes</text>
                </option>
                <option>
                    <value>0</value>
                    <text>No</text>
                </option>
            </options>
            <help>Display a chart in the statistics?</help>
            <caption>Display chart</caption>
            <default>1</default>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>statistics_graphtype</name>
            <category>Statistics</category>
            <inputtype>singleselect</inputtype>
            <sortorder>102</sortorder>
            <options>
                <option>
                    <value>0</value>
                    <text>Bar chart</text>
                </option>
                <option>
                    <value>1</value>
                    <text>Pie chart</text>
                </option>
                <option>
                    <value>2</value>
                    <text>Radar</text>
                </option>
                <option>
                    <value>3</value>
                    <text>Line</text>
                </option>
                <option>
                    <value>4</value>
                    <text>PolarArea</text>
                </option>
                <option>
                    <value>5</value>
                    <text>Doughnut</text>
                </option>
            </options>
            <help>Select the type of chart to be displayed</help>
            <caption>Chart type</caption>
            <default>0</default>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <!-- Statistics Attributes END -->
        <!-- Timer Attributes START -->
        <attribute>
            <name>time_limit_timer_style</name>
            <category>Timer</category>
            <sortorder>100</sortorder>
            <inputtype>textarea</inputtype>
            <help>CSS Style for the message that displays in the countdown timer during the countdown</help>
            <caption>Time limit timer CSS style</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>time_limit_message_delay</name>
            <category>Timer</category>
            <sortorder>102</sortorder>
            <inputtype>integer</inputtype>
            <help>Display the &amp;#039;time limit expiry message&amp;#039; for this many seconds before performing
                the &amp;#039;time limit action&amp;#039; (defaults to 1 second if left blank)
            </help>
            <caption>Time limit expiry message display time</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>time_limit_message</name>
            <category>Timer</category>
            <sortorder>104</sortorder>
            <inputtype>textarea</inputtype>
            <expression>1</expression>
            <i18n>1</i18n>
            <help>The message to display when the time limit has expired (a default message will display if this
                setting is left blank)
            </help>
            <caption>Time limit expiry message</caption>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
        </attribute>
        <attribute>
            <name>time_limit_message_style</name>
            <category>Timer</category>
            <sortorder>106</sortorder>
            <inputtype>textarea</inputtype>
            <help>CSS style for the &amp;#039;time limit expiry message&amp;#039;</help>
            <caption>Time limit message CSS style</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>time_limit_warning</name>
            <category>Timer</category>
            <sortorder>108</sortorder>
            <inputtype>integer</inputtype>
            <help>Display a &amp;#039;time limit warning&amp;#039; when there are this many seconds remaining in the
                countdown (warning will not display if left blank)
            </help>
            <caption>1st time limit warning message timer</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>time_limit_warning_display_time</name>
            <category>Timer</category>
            <sortorder>110</sortorder>
            <inputtype>integer</inputtype>
            <help>The &amp;#039;time limit warning&amp;#039; will stay visible for this many seconds (will not turn
                off if this setting is left blank)
            </help>
            <caption>1st time limit warning message display time</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>time_limit_warning_message</name>
            <category>Timer</category>
            <sortorder>112</sortorder>
            <inputtype>textarea</inputtype>
            <expression>1</expression>
            <i18n>1</i18n>
            <help>The message to display as a &amp;#039;time limit warning&amp;#039; (a default warning will display
                if this is left blank)
            </help>
            <caption>1st time limit warning message</caption>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
        </attribute>
        <attribute>
            <name>time_limit_warning_style</name>
            <category>Timer</category>
            <sortorder>114</sortorder>
            <inputtype>textarea</inputtype>
            <help>CSS style used when the &amp;#039;time limit warning&amp;#039; message is displayed</help>
            <caption>1st time limit warning CSS style</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>time_limit_warning_2</name>
            <category>Timer</category>
            <sortorder>116</sortorder>
            <inputtype>integer</inputtype>
            <help>Display the 2nd &amp;#039;time limit warning&amp;#039; when there are this many seconds remaining
                in the countdown (warning will not display if left blank)
            </help>
            <caption>2nd time limit warning message timer</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>time_limit_warning_2_display_time</name>
            <category>Timer</category>
            <sortorder>118</sortorder>
            <inputtype>integer</inputtype>
            <help>The 2nd &amp;#039;time limit warning&amp;#039; will stay visible for this many seconds (will not
                turn off if this setting is left blank)
            </help>
            <caption>2nd time limit warning message display time</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>time_limit_warning_2_message</name>
            <category>Timer</category>
            <sortorder>120</sortorder>
            <inputtype>textarea</inputtype>
            <expression>1</expression>
            <i18n>1</i18n>
            <help>The 2nd message to display as a &amp;#039;time limit warning&amp;#039; (a default warning will
                display if this is left blank)
            </help>
            <caption>2nd time limit warning message</caption>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
        </attribute>
        <attribute>
            <name>time_limit_warning_2_style</name>
            <category>Timer</category>
            <sortorder>122</sortorder>
            <inputtype>textarea</inputtype>
            <help>CSS style used when the 2nd &amp;#039;time limit warning&amp;#039; message is displayed</help>
            <caption>2nd time limit warning CSS style</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>time_limit</name>
            <category>Timer</category>
            <sortorder>90</sortorder>
            <inputtype>integer</inputtype>
            <help>Limit time to answer question (in seconds)</help>
            <caption>Time limit</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>time_limit_action</name>
            <category>Timer</category>
            <sortorder>92</sortorder>
            <inputtype>singleselect</inputtype>
            <options>
                <option>
                    <value>1</value>
                    <text>Warn and move on</text>
                </option>
                <option>
                    <value>2</value>
                    <text>Move on without warning</text>
                </option>
                <option>
                    <value>3</value>
                    <text>Disable only</text>
                </option>
            </options>
            <default>1</default>
            <help>Action to perform when time limit is up</help>
            <caption>Time limit action</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>time_limit_disable_next</name>
            <category>Timer</category>
            <sortorder>94</sortorder>
            <inputtype>switch</inputtype>
            <default>0</default>
            <options>
                <option>
                    <value>0</value>
                    <text>No</text>
                </option>
                <option>
                    <value>1</value>
                    <text>Yes</text>
                </option>
            </options>
            <help>Disable the next button until time limit expires</help>
            <caption>Time limit disable next</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>time_limit_disable_prev</name>
            <category>Timer</category>
            <sortorder>96</sortorder>
            <inputtype>switch</inputtype>
            <options>
                <option>
                    <value>0</value>
                    <text>No</text>
                </option>
                <option>
                    <value>1</value>
                    <text>Yes</text>
                </option>
            </options>
            <default>0</default>
            <help>Disable the prev button until the time limit expires</help>
            <caption>Time limit disable prev</caption>
            <i18n></i18n>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
            <expression></expression>
        </attribute>
        <attribute>
            <name>time_limit_countdown_message</name>
            <category>Timer</category>
            <sortorder>98</sortorder>
            <inputtype>textarea</inputtype>
            <expression>1</expression>
            <i18n>1</i18n>
            <help>The text message that displays in the countdown timer during the countdown</help>
            <caption>Time limit countdown message</caption>
            <readonly></readonly>
            <readonly_when_active></readonly_when_active>
        </attribute>
        <!-- Timer Attributes END -->
    </attributes>

    <!-- Core question js/css configuration -->
    <engine>
        <load_core_css>true</load_core_css>
        <load_core_js>true</load_core_js>
        <show_as_template>true</show_as_template>
        <show_as_question_type>true</show_as_question_type>
    </engine>
</config>
XML;

    /**
     * @return void
     */
    public function testBasic()
    {
        $appConfig = ['rootdir' => ''];
        $xmlIO =
            (new class($this->dummyLS3config, $this->dummyLS4config) extends XmlIO {
                public $convertedXml = '';
                public function __construct($dummyLS3config, $dummyLS4config)
                {
                    $this->dummyLS3config = $dummyLS3config;
                    $this->dummyLS4config = $dummyLS4config;
                }
                public function save($xml, $path)
                {
                    $this->convertedXml = $xml;
                    return true;
                }
                public function load($path)
                {
                    if ($path === '/listradio/config.xml') {
                        return new \SimpleXMLElement($this->dummyLS3config);
                    } elseif ($path === '/application/views/survey/questions/answer/listradio/config.xml') {
                        return new \SimpleXMLElement($this->dummyLS4config);
                    } else {
                        throw new \Exception('Unknown path, mock XmlIO failed');
                    }
                }
            });
        $converter = new QuestionThemeConverter($appConfig, $xmlIO);

        /** @var array */
        $result = $converter->convert('listradio');

        $this->assertTrue($result['success']);
        $this->assertNotEmpty($xmlIO->convertedXml->attributes);
        $this->assertEmpty($xmlIO->convertedXml->custom_attributes);
    }
}