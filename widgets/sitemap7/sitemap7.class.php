<?php
    /**
     * @class sitemap
     * @author jedison (master@xgenesis.org)
     * @version 0.1
     * @brief 설정된 메뉴를 이용하여 사이트맵 출력
     **/

    class sitemap7 extends WidgetHandler {

        /**
         * @brief 위젯의 실행 부분
         * ./widgets/위젯/conf/info.xml에 선언한 extra_vars를 args로 받는다
         * 결과를 만든후 print가 아니라 return 해주어야 한다
         **/
        function proc($args) {
        	
        	// 메뉴설정
            $php_file = sprintf('%sfiles/cache/menu/%d.php', _XE_PATH_, $args->sitemap_widget_menu);
			$php_file2 = sprintf('%sfiles/cache/menu/%d2.php', _XE_PATH_, $args->sitemap_widget_menu2);
			$php_file3 = sprintf('%sfiles/cache/menu/%d3.php', _XE_PATH_, $args->sitemap_widget_menu3);
            @include($php_file);
			@include($php_file2);
			@include($php_file3);
            $widget_info->sitemap_widget_menu = $menu;
			$widget_info->sitemap_widget_menu2 = $menu2;
			$widget_info->sitemap_widget_menu3 = $menu3;
            
            // 컬러셋설정
            if($args->sitemap_widget_colorset==null){
            	$args->sitemap_widget_colorset = "black";
            }
			$widget_info->sitemap_widget_colorset = $args->sitemap_widget_colorset;
			
			// 추가설정
				// 배경색
				$widget_info->sitemap_widget_background = $args->sitemap_widget_background;
				
				// 사이트맵높이설정
	        	if($args->sitemap_widget_height==null){
	            	$args->sitemap_widget_height = "560px";
	            }
				
	        	$widget_info->sitemap_widget_height = $args->sitemap_widget_height;
	        	
				// 섹션최소높이설정
        		if($args->sitemap_widget_section_height==null){
	            	$args->sitemap_widget_section_height = "400px";
	            }
	        	$widget_info->sitemap_widget_section_height = $args->sitemap_widget_section_height;
        		
        	// 테두리설정
        		$widget_info->sitemap_widget_border_size = $args->sitemap_widget_border_size;
        		$widget_info->sitemap_widget_border_kind = $args->sitemap_widget_border_kind;
        		$widget_info->sitemap_widget_border_color = $args->sitemap_widget_border_color;
			// 링크설정
				$widget_info->sitemap_widget_link_color = $args->sitemap_widget_link_color;
				$widget_info->sitemap_widget_link_visited_color = $args->sitemap_widget_link_visited_color;
				$widget_info->sitemap_widget_link_hover_color= $args->sitemap_widget_link_hover_color;
				$widget_info->sitemap_widget_link_active_color = $args->sitemap_widget_link_active_color;        		
            Context::set('widget_info', $widget_info);

            // 템플릿 컴파일
            $tpl_path = sprintf('%sskins/%s', $this->widget_path, $args->skin);
            $tpl_file = 'sitemap';

            $oTemplate = &TemplateHandler::getInstance();
            return $oTemplate->compile($tpl_path, $tpl_file);
        }
    }
?>