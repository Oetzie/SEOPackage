<?php

/**
 * SEO Package
 *
 * Copyright 2020 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

$_lang['seopackage']                                            = 'Searchengine optimalisation';
$_lang['seopackage.desc']                                       = 'Change or create URL redirects.';

$_lang['area_seopackage']                                       = 'Searchengine optimalisation';
$_lang['area_seopackage_seo']                                   = 'Searchengine optimalisation (SEO)';
$_lang['area_seopackage_ip']                                    = 'Searchengine optimalisation (IP exceptions)';

$_lang['setting_seopackage.branding_url']                       = 'Branding';
$_lang['setting_seopackage.branding_url_desc']                  = 'The URL of the branding button, if the URL is empty the branding button won\'t be shown.';
$_lang['setting_seopackage.branding_url_help']                  = 'Branding (help)';
$_lang['setting_seopackage.branding_url_help_desc']             = 'The URL of the branding help button, if the URL is empty the branding help button won\'t be shown.';
$_lang['setting_seopackage.files']                              = 'File extensions';
$_lang['setting_seopackage.files_desc']                         = 'The file extensions to exclude the files from the error pages (404). Separate multiple file extensions with a comma.';
$_lang['setting_seopackage.migrate']                            = 'Migration';
$_lang['setting_seopackage.migrate_desc']                       = 'When \'Yes\', all the resource are migrated correctly.';
$_lang['setting_seopackage.clean_days']                         = 'Clean up period (days)';
$_lang['setting_seopackage.clean_days_desc']                    = 'The clean up period, after this day all old 404 pages will be removed. Default is \'30\'.';
$_lang['setting_seopackage.clean_hits']                         = 'Clean up period (hits)';
$_lang['setting_seopackage.clean_hits_desc']                    = 'The clean up period, after this hits all old 404 pages will be removed. Default is \'0\'.';
$_lang['setting_seopackage.log_send']                           = 'Send log';
$_lang['setting_seopackage.log_send_desc']                      = 'When yes, send the log file that will be created by email.';
$_lang['setting_seopackage.log_email']                          = 'Log e-mail address(es)';
$_lang['setting_seopackage.log_email_desc']                     = 'The e-mail address(es) where the log file needs to be send. Separate e-mail addresses with a comma.';
$_lang['setting_seopackage.log_lifetime']                       = 'Log lifetime';
$_lang['setting_seopackage.log_lifetime_desc']                  = 'The number of days that a log file needs to be saved, after this the log file will be deleted automatically.';
$_lang['setting_seopackage.cronjob_hash']                       = 'Cronjob hash';
$_lang['setting_seopackage.cronjob_hash_desc']                  = 'The hash of the cronjob, this hash needs to be send as a parameter with the cronjob.';
$_lang['setting_seopackage.exclude_contexts']                   = 'Exclude contexts';
$_lang['setting_seopackage.exclude_contexts_desc']              = 'The contexts to exclude from \'URL redirects\', separate multiple contexts with a comma.';
$_lang['setting_seopackage.seo_fields']                         = 'SEO fields';
$_lang['setting_seopackage.seo_fields_desc']                    = 'The fields to be checked for SEO length. This must be a valid JSON, default is \'{"google": {"pagetitle": "50|60", "longtitle": "50|60", "description": "50|160"}, "yandex": {"pagetitle": "50|60", "longtitle": "50|60", "description": "50|160"}}\'.';
$_lang['setting_seopackage.seo_keywords_fields']                = 'SEO keyword(s) fields';
$_lang['setting_seopackage.seo_keywords_fields_desc']           = 'The fields to be checked for SEO keyword(s). Separate multiple fields with a comma, default is \'longtitle,description,alias,ta\'.';
$_lang['setting_seopackage.seo_fields_style']                   = 'SEO fields style';
$_lang['setting_seopackage.seo_fields_style_desc']              = 'The style of the SEO fields, this can be \'bar\' or \'counter\'. Default is \'bar\'.';
$_lang['setting_seopackage.seo_title_format']                   = 'SEO title format';
$_lang['setting_seopackage.seo_title_format_desc']              = 'The format of the SEO title, this title will be used in the \'head\'. Default is \'[[+title]] - [[++site_name]]\'.';
$_lang['setting_seopackage.seo_description_format']             = 'SEO description format';
$_lang['setting_seopackage.seo_description_format_desc']        = 'The format of the SEO description, this description will be used in the \'head\'. Default is \'[[++description]]\'.';
$_lang['setting_seopackage.seo_title_home_format']              = 'SEO title format (homepage)';
$_lang['setting_seopackage.seo_title_home_format_desc']         = 'The format of the SEO title (homepage), this title will be used in the \'head\'. Default is \'[[++site_name]] - [[+title]]\'.';
$_lang['setting_seopackage.preview_search_engine']              = 'Preview searchengine';
$_lang['setting_seopackage.preview_search_engine_desc']         = 'The searchengine for the searchengine preview. This can be "google" or "yandex", default is "google".';
$_lang['setting_seopackage.seo_index']                          = 'Index searchengine';
$_lang['setting_seopackage.seo_index_desc']                     = 'The default index for searchengines. Default is "Yes".';
$_lang['setting_seopackage.seo_follow']                         = 'Follow links searchengine';
$_lang['setting_seopackage.seo_follow_desc']                    = 'The default follow links for searchengines. Default is "Yes".';
$_lang['setting_seopackage.seo_searchable']                     = 'Display in internal searchengines';
$_lang['setting_seopackage.seo_searchable_desc']                = 'The default display for in the internal searchengine. Default is "Yes".';
$_lang['setting_seopackage.seo_sitemap']                        = 'Display in sitemap';
$_lang['setting_seopackage.seo_sitemap_desc']                   = 'The default display for in the sitemap. Default is "Ja".';
$_lang['setting_seopackage.seo_sitemap_prio']                   = 'Sitemap priority';
$_lang['setting_seopackage.seo_sitemap_prio_desc']              = 'The default sitemap priority. Default is "0.5".';
$_lang['setting_seopackage.seo_sitemap_freq']                   = 'Sitemap update frequency';
$_lang['setting_seopackage.seo_sitemap_freq_desc']              = 'The default sitemap update frequency. Default is "weekly".';
$_lang['setting_seopackage.404_page_replace_params']            = 'Replace 404 page URL params';
$_lang['setting_seopackage.404_page_replace_params_desc']       = 'If yes, the 404 page URL params will be replaced for a wildcard (%). Default is "Yes".';
$_lang['setting_seopackage.ip_save_manager']                    = 'Save manager login IP number';
$_lang['setting_seopackage.ip_save_manager_desc']               = 'If yes, the IP number will be saved so that it can always access the website when the site status is offline. Default is "Ja".';
$_lang['setting_seopackage.ip_auto_block']                      = 'Deny IP number';
$_lang['setting_seopackage.ip_auto_block_desc']                 = 'If yes, the IP number will be saved and denied if it tries to visit an unauthorized URL. Default is "Ja".';
$_lang['setting_seopackage.ip_auto_block_urls']                 = 'Deny IP number URLs';
$_lang['setting_seopackage.ip_auto_block_urls_desc']            = 'The URLs through which the IP number is saved and denied. Separate multiple URLs with a comma.';

$_lang['seopackage.redirect']                                   = 'URL redirect';
$_lang['seopackage.redirects']                                  = 'URL redirects';
$_lang['seopackage.redirects_desc']                             = 'Manage here all URL redirects. An URL is meant to redirect old pages to the new pages, for example links from other websites to your site. It is possible to use wildcards. For a wildcard in the old URL use % (use $NUMBER_WILDCARD to use the wildcard in the new URL), use a ^ to start an IP sequence (e.g. ^ 172.0.) Or use $ to end an IP sequence (e.g. .0.1 $).';
$_lang['seopackage.redirect_create']                            = 'Create new URL redirect';
$_lang['seopackage.redirect_update']                            = 'Update URL redirect';
$_lang['seopackage.redirect_remove']                            = 'Delete URL redirect';
$_lang['seopackage.redirect_remove_confirm']                    = 'Are you sure you want to delete this URL redirect? This can be bad for your SEO.';
$_lang['seopackage.redirects_reset']                            = 'Delete all URL redirects';
$_lang['seopackage.redirects_reset_confirm']                    = 'Are you sure you want to delete all URL redirects?';

$_lang['seopackage.error']                                      = '404 page';
$_lang['seopackage.errors']                                     = '404 pages';
$_lang['seopackage.errors_desc']                                = 'Manage here all your 404 pages. A 404 page is automatically detected and means that a link to a page no longer exists. A link that reaches the 404 page, especially that of Google, is bad for your SEO. For these 404 pages you must create an URL redirect.';
$_lang['seopackage.error_create']                               = 'Create new URL redirect';
$_lang['seopackage.error_remove']                               = 'Delete 404 page';
$_lang['seopackage.error_remove_confirm']                       = 'Are you sure you want to delete this 404 page? This can be bad for your SEO.';
$_lang['seopackage.errors_clean']                               = 'Clean 404 pages';
$_lang['seopackage.errors_clean_confirm']                       = 'Are you sure you want to clean up all 404 pages?';
$_lang['seopackage.errors_reset']                               = 'Delete all 404 pages';
$_lang['seopackage.errors_reset_confirm']                       = 'Are you sure you want to delete all 404 pages?';

$_lang['seopackage.ip']                                         = 'IP exception';
$_lang['seopackage.ips']                                        = 'IP exceptions';
$_lang['seopackage.ips_desc']                                   = 'Manage here all your IP exceptions. An IP exception is intended to grant or deny a visitor access to the website on the basis of the IP number (if the website is offline, for example). It is possible to use wildcards in the IP exception. For a wildcard in the IP number use%, use a ^ to start an IP sequence (eg ^ 172.0.) Or use $ to end an IP sequence (eg .0.1 $).';
$_lang['seopackage.ip_create']                                  = 'Create new IP exception';
$_lang['seopackage.ip_update']                                  = 'Update IP exception';
$_lang['seopackage.ip_remove']                                  = 'Delete IP exception';
$_lang['seopackage.ip_remove_confirm']                          = 'Are you sure you want to delete this IP exception?';

$_lang['seopackage.label_url']                                  = 'URL';
$_lang['seopackage.label_url_desc']                             = '';
$_lang['seopackage.label_old_url']                              = 'Old URL';
$_lang['seopackage.label_old_url_desc']                         = 'The old URL of the redirect (without host). For a wildcard use % (use $NUMBER_WILDCARD to use the wildcard in the new URLs), use ^ to start an URL range (ex. ^news) or use $ to end an URL range (ex. news$).';
$_lang['seopackage.label_new_url']                              = 'New URL';
$_lang['seopackage.label_new_url_desc']                         = 'The new URL of the redirect to redirect to (without host). This can be an ID of a resource.';
$_lang['seopackage.label_context']                              = 'Context';
$_lang['seopackage.label_context_desc']                         = 'The context of the redirect. If there is no context selected the redirect will be valid on all contexts.';
$_lang['seopackage.label_redirect_type']                        = 'Redirect type';
$_lang['seopackage.label_redirect_type_desc']                   = 'The type of the redirect.';
$_lang['seopackage.label_active']                               = 'Active';
$_lang['seopackage.label_active_desc']                          = '';
$_lang['seopackage.label_visits']                               = 'Hits';
$_lang['seopackage.label_visits_desc']                          = '';
$_lang['seopackage.label_last_visit']                           = 'Latest hit';
$_lang['seopackage.label_last_visit_desc']                      = '';

$_lang['seopackage.label_clean_days_label']                     = 'Delete 404 pages with the last hit longer than';
$_lang['seopackage.label_clean_days_desc']                      = 'days ago.';
$_lang['seopackage.label_clean_hits_label']                     = 'Or delete 404 pages with less than';
$_lang['seopackage.label_clean_hits_desc']                      = 'hits.';

$_lang['seopackage.label_ip_description']                       = 'Description';
$_lang['seopackage.label_ip_description_desc']                  = 'The description of the IP exception.';
$_lang['seopackage.label_ip_ip']                                = 'IP number';
$_lang['seopackage.label_ip_ip_desc']                           = 'The IP number of the IP exception.';
$_lang['seopackage.label_ip_type']                              = 'Exceptiontype';
$_lang['seopackage.label_ip_type_desc']                         = 'The exceptiontype of the IP exception.';
$_lang['seopackage.label_ip_active']                            = 'Active';
$_lang['seopackage.label_ip_active_desc']                       = '';
$_lang['seopackage.label_ip_context']                           = 'Context';
$_lang['seopackage.label_ip_context_desc']                      = 'The context of the IP exception. If there is no context selected the IP exception will be valid on all contexts.';

$_lang['seopackage.resource_longtitle']                         = 'Searchengine title';
$_lang['seopackage.resource_description']                       = 'Searchengine description';
$_lang['seopackage.resource_keywords']                          = 'Searchengine keyword(s)';
$_lang['seopackage.resource_keywords_desc']                     = 'The searchengine keyword(s), separate multiple keywords with a comma.';
$_lang['seopackage.resource_index']                             = 'Searchengines are allowed to index this page';
$_lang['seopackage.resource_index_desc']                        = 'If checked the searchengines like Google or Yandex will index this page.';
$_lang['seopackage.resource_follow']                            = 'Searchengines are allowed to follow links on this page.';
$_lang['seopackage.resource_follow_desc']                       = 'If checked the searchengines like Google or Yandex will follow the links on this page.';
$_lang['seopackage.resource_searchable']                        = 'Display in internal searchengines';
$_lang['seopackage.resource_searchable_desc']                   = 'If checked the page will be displayed in the internal searchengines.';
$_lang['seopackage.resource_sitemap']                           = 'Display in sitemap';
$_lang['seopackage.resource_sitemap_desc']                      = 'If checked the page will be displayed in the sitemap.';
$_lang['seopackage.resource_sitemap_prio']                      = 'Sitemap priority';
$_lang['seopackage.resource_sitemap_prio_desc']                 = 'Give searchengines an indication of the importance of this page by setting the priority. Note: the priority is not blindly taken over by search engines!';
$_lang['seopackage.resource_sitemap_freq']                      = 'Sitemap update frequency';
$_lang['seopackage.resource_sitemap_freq_desc']                 = 'Give searchengines an indication of how often this page will be changed by setting the update frequency. Note: the update frequency is not blindly taken over by search engines!';
$_lang['seopackage.seo_preview']                                = 'Searchengine preview ([[+type]])';
$_lang['seopackage.seo_preview_desc']                           = 'Add a description. If you don\'t, the searchengine will try to find a relevant piece of the page to show in the search results.';
$_lang['seopackage.resource_allowed_chars']                     = 'Characters';
$_lang['seopackage.resource_allowed_keywords']                  = 'Searchengine keyword(s)';

$_lang['seopackage.filter_context']                             = 'Filter on context...';
$_lang['seopackage.filter_files']                               = 'Show files';
$_lang['seopackage.errors_clean_desc']                          = 'This function makes it possible to delete 404 pages that have not been visited since the specified number of days. This promotion cannot be reversed!';
$_lang['seopackage.errors_clean_executing']                     = 'Busy with cleaning up 404 pages';
$_lang['seopackage.errors_clean_success']                       = '[[+amount]] 404 pages removed.';
$_lang['seopackage.migrate_redirections']                       = 'Migrate existing pages';
$_lang['seopackage.migrate_redirections_confirm']               = 'Are you sure you want to migrate all existing pages?';
$_lang['seopackage.migrate_redirections_success']               = '[[+urls]] URLs and [[+pages]] pages migrated.';
$_lang['seopackage.seo_preview_not_allowed']                    = 'Searchengines are now allowed to index this page, therefore no preview is possible.';
$_lang['seopackage.seo_sitemap_prio_high']                      = '1.0 - High';
$_lang['seopackage.seo_sitemap_prio_normal']                    = '0.5 - Normal';
$_lang['seopackage.seo_sitemap_prio_low']                       = '0.25 - Low';
$_lang['seopackage.seo_sitemap_freq_always']                    = 'Always';
$_lang['seopackage.seo_sitemap_freq_hourly']                    = 'Hourly';
$_lang['seopackage.seo_sitemap_freq_daily']                     = 'Daily';
$_lang['seopackage.seo_sitemap_freq_weekly']                    = 'Weekly';
$_lang['seopackage.seo_sitemap_freq_monthly']                   = 'Monthly';
$_lang['seopackage.seo_sitemap_freq_yearly']                    = 'Yearly';
$_lang['seopackage.seo_sitemap_freq_never']                     = 'Never';
$_lang['seopackage.empty_context']                              = 'All contexts';
$_lang['seopackage.ip_allow']                                   = 'Allow';
$_lang['seopackage.ip_deny']                                    = 'Deny';
$_lang['seopackage.access_denied']                              = 'Your access to the website has been blocked by the Administrator, for more information please contact<a href="mailto:[[++emailsender]]">[[++emailsender]]</a>.';
