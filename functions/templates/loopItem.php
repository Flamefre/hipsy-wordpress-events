<?php
function loop_item($url, $thumbnail, $formatted_date, $formatted_time, $formatted_time_end, $title, $location, $termlist)
{
	return <<<EOT
        <div class="event">
            <div class="event-image-wrapper"><a href="{$url}">{$thumbnail}</a></div>
            <div class="event-info">
                <div class="event-date">{$formatted_date} {$formatted_time} - {$formatted_time_end}</div>
                <div class="event-title"><a href="{$url}">{$title}</a></div>
                <div class="event-location">{$location}</div>
                <div class="event-category">{$termlist}</div>
            </div>
        </div>
    EOT;
}

function loop_wrapper_start($value)
{
	return '<div class="hipsy-events-widget ' . $value . '">';
}

function loop_wrapper_end()
{
	return '</div>';
}
