<?php

/**
 * SEO Package
 *
 * Copyright 2020 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

$_lang['seopackage']                                            = 'Zoekmachine optimalisatie';
$_lang['seopackage.desc']                                       = 'Wijzig of maak URL verwijzingen.';

$_lang['area_seopackage']                                       = 'Zoekmachine optimalisatie';
$_lang['area_seopackage_seo']                                   = 'Zoekmachine optimalisatie (SEO)';

$_lang['setting_seopackage.branding_url']                       = 'Branding';
$_lang['setting_seopackage.branding_url_desc']                  = 'De URL waar de branding knop heen verwijst, indien leeg wordt de branding knop niet getoond.';
$_lang['setting_seopackage.branding_url_help']                  = 'Branding (help)';
$_lang['setting_seopackage.branding_url_help_desc']             = 'De URL waar de branding help knop heen verwijst, indien leeg wordt de branding help knop niet getoond.';
$_lang['setting_seopackage.files']                              = 'Bestandsextensies';
$_lang['setting_seopackage.files_desc']                         = 'De extensies om de bestanden uit de foutpagina\'s (404) te filteren. Meerdere bestandsextensies scheiden met een komma.';
$_lang['setting_seopackage.migrate']                            = 'Migratie';
$_lang['setting_seopackage.migrate_desc']                       = 'Indien \'Ja\', dan zijn alle pagina\'s goed gemigreerd.';
$_lang['setting_seopackage.clean_days']                         = 'Opruim periode';
$_lang['setting_seopackage.clean_days_desc']                    = 'Het aantal dagen waarna oude 404 pagina\'s verwijderd worden. Standaard is \'30\'.';
$_lang['setting_seopackage.log_send']                           = 'Log versturen';
$_lang['setting_seopackage.log_send_desc']                      = 'Indien ja, het aangemaakte log bestand die automatisch word aangemaakt versturen via e-mail.';
$_lang['setting_seopackage.log_email']                          = 'Log e-mailadres(sen)';
$_lang['setting_seopackage.log_email_desc']                     = 'De e-mailadres(sen) waar het log bestand heen gestuurd dient te worden. Meerdere e-mailadressen scheiden met een komma.';
$_lang['setting_seopackage.log_lifetime']                       = 'Log levensduur';
$_lang['setting_seopackage.log_lifetime_desc']                  = 'Het aantal dagen dat een log bestand bewaard moet blijven, hierna word het log bestand automatisch verwijderd.';
$_lang['setting_seopackage.cronjob_hash']                       = 'Cronjob hash';
$_lang['setting_seopackage.cronjob_hash_desc']                  = 'De hash van de cronjob, deze hash dient als parameter mee gegeven te worden met de cronjob.';
$_lang['setting_seopackage.exclude_contexts']                   = 'Contexten uitsluiten';
$_lang['setting_seopackage.exclude_contexts_desc']              = 'De contexten die uitgesloten zijn voor \'URL verwijzigen\', meerdere contexten scheiden met een komma.';
$_lang['setting_seopackage.seo_fields']                         = 'SEO velden';
$_lang['setting_seopackage.seo_fields_desc']                    = 'De velden die gecontrolleerd worden op SEO lengte. Dit moet een geldige JSON formaat zijn, standaard is \'{"google": {"pagetitle": "50|60", "longtitle": "50|60", "description": "50|160"}, "yandex": {"pagetitle": "50|60", "longtitle": "50|60", "description": "50|160"}}\'.';
$_lang['setting_seopackage.seo_keywords_fields']                = 'SEO keyword(s) velden';
$_lang['setting_seopackage.seo_keywords_fields_desc']           = 'De velden die gecontrolleerd worden op SEO keyword(s). Meerdere velden scheiden met een komma, standaard is \'longtitle,description,alias,ta\'.';
$_lang['setting_seopackage.seo_fields_style']                   = 'SEO velden stijl';
$_lang['setting_seopackage.seo_fields_style_desc']              = 'De style van de SEO velden, dit kan \'bar\' of \'counter\' zijn. Standaard \'bar\'.';
$_lang['setting_seopackage.seo_title_format']                   = 'SEO titel formaat';
$_lang['setting_seopackage.seo_title_format_desc']              = 'De SEO title formaat, deze titel word in de \'head\' gebruikt. Standaard is \'[[+title]] - [[++site_name]]\'.';
$_lang['setting_seopackage.seo_description_format']             = 'SEO omschrijving formaat';
$_lang['setting_seopackage.seo_description_format_desc']        = 'De SEO omschrijving formaat, deze omschrijving word in de \'head\' gebruikt. Standaard is \'[[+description]]\'.';
$_lang['setting_seopackage.preview_search_engine']              = 'Preview zoekmachine';
$_lang['setting_seopackage.preview_search_engine_desc']         = 'De zoekmachine voor de zoekmachine voorbeeld. Dit kan "google" of "yandex" zijn, standaard is "google".';
$_lang['setting_seopackage.seo_index']                          = 'Zoekmachines indexeren';
$_lang['setting_seopackage.seo_index_desc']                     = 'De standaard zoekmachines indexeren. Standaard is "Ja".';
$_lang['setting_seopackage.seo_follow']                         = 'Zoekmachines links volgen';
$_lang['setting_seopackage.seo_follow_desc']                    = 'De standaard zoekmachines links volgen. Standaard is "Ja".';
$_lang['setting_seopackage.seo_searchable']                     = 'Tonen in interne zoekmachines';
$_lang['setting_seopackage.seo_searchable_desc']                = 'De standaard tonen in interne zoekmachines. Standaard is "Ja".';
$_lang['setting_seopackage.seo_sitemap']                        = 'Tonen in sitemap';
$_lang['setting_seopackage.seo_sitemap_desc']                   = 'De standaard tonen in sitemap. Standaard is "Ja".';
$_lang['setting_seopackage.seo_sitemap_prio']                   = 'Sitemap prioriteit';
$_lang['setting_seopackage.seo_sitemap_prio_desc']              = 'De standaard sitemap prioriteit. Standaard is "0.5".';
$_lang['setting_seopackage.seo_sitemap_freq']                   = 'Sitemap update frequentie';
$_lang['setting_seopackage.seo_sitemap_freq_desc']              = 'De standaard sitemap update frequentie. Standaard is "weekly".';

$_lang['seopackage.redirect']                                   = 'URL verwijzing';
$_lang['seopackage.redirects']                                  = 'URL verwijzingen';
$_lang['seopackage.redirects_desc']                             = 'Beheer hier alle URL verwijzingen. Een URL verwijzing is bedoelt om oude pagina\'s naar de nieuwe pagina\'s te door te wijzen, bijvoorbeeld links vanuit een andere websites naar jouw website.';
$_lang['seopackage.redirect_create']                            = 'Nieuwe URL verwijzing';
$_lang['seopackage.redirect_update']                            = 'URL verwijzing wijzigen';
$_lang['seopackage.redirect_remove']                            = 'URL verwijzing verwijderen';
$_lang['seopackage.redirect_remove_confirm']                    = 'Weet je zeker dat je deze URL verwijzing wilt verwijderen? Dit kan een slecht invloed hebben voor de SEO.';
$_lang['seopackage.redirects_reset']                            = 'Alle URL verwijzingen verwijderen';
$_lang['seopackage.redirects_reset_confirm']                    = 'Weet je zeker dat je alle URL verwijzingen wilt verwijderen?';

$_lang['seopackage.error']                                      = '404 pagina';
$_lang['seopackage.errors']                                     = '404 pagina\'s';
$_lang['seopackage.errors_desc']                                = 'Bekijk hier hier alle 404 pagina\'s. Een 404 pagina word automatisch gedetecteerd en betekend dat een link naar een pagina niet (meer) bestaat. Een link die bij de 404 pagina uitkomt, vooral die van Google, is slecht voor je SEO. Voor deze 404 pagina\'s dien je dus een URL verwijzing te maken.';
$_lang['seopackage.error_create']                               = 'Nieuwe URL verwijzing';
$_lang['seopackage.error_remove']                               = '404 pagina verwijderen';
$_lang['seopackage.error_remove_confirm']                       = 'Weet je zeker dat je deze 404 pagina wilt verwijderen? Dit kan een slecht invloed hebben voor de SEO.';
$_lang['seopackage.errors_clean']                               = '404 pagina\'s opruimen';
$_lang['seopackage.errors_clean_confirm']                       = 'Weet je zeker dat je alle 404 pagina\'s wilt opruimen?';
$_lang['seopackage.errors_reset']                               = 'Alle 404 pagina\'s verwijderen';
$_lang['seopackage.errors_reset_confirm']                       = 'Weet je zeker dat je alle 404 pagina\'s wilt verwijderen?';

$_lang['seopackage.label_url']                                  = 'URL';
$_lang['seopackage.label_url_desc']                             = '';
$_lang['seopackage.label_old_url']                              = 'Oude URL';
$_lang['seopackage.label_old_url_desc']                         = 'De oude URL van de verwijzing (zonder host). Voor een wildcard gebruik % (deze wildcard kun je door geven aan de nieuwe URL met $1), gebruik een ^ om een URL reeks te starten (bv ^nieuws) of gebruik $ om een URL reeks te eindigen (bv nieuws$).';
$_lang['seopackage.label_new_url']                              = 'Nieuwe URL';
$_lang['seopackage.label_new_url_desc']                         = 'De nieuwe URL waar de verwijzing heen moet verwijzen (zonder host). Dit kan ook een ID van een pagina zijn.';
$_lang['seopackage.label_context']                              = 'Context';
$_lang['seopackage.label_context_desc']                         = 'De context van de verwijzing. Als er geen context geselecteerd word geldt deze verwijzing voor alle contexten.';
$_lang['seopackage.label_redirect_type']                        = 'Verwijzingstype';
$_lang['seopackage.label_redirect_type_desc']                   = 'De type van de verwijzing.';
$_lang['seopackage.label_active']                               = 'Actief';
$_lang['seopackage.label_active_desc']                          = '';
$_lang['seopackage.label_visits']                               = 'Hits';
$_lang['seopackage.label_visits_desc']                          = '';
$_lang['seopackage.label_last_visit']                           = 'Laatste hit';
$_lang['seopackage.label_last_visit_desc']                      = '';

$_lang['seopackage.label_clean_label']                          = 'Verwijder 404 pagina\'s ouder dan';
$_lang['seopackage.label_clean_desc']                           = 'dagen.';

$_lang['seopackage.resource_longtitle']                         = 'Zoekmachine titel';
$_lang['seopackage.resource_description']                       = 'Zoekmachine omschrijving';
$_lang['seopackage.resource_keywords']                          = 'Zoekmachine keyword(s)';
$_lang['seopackage.resource_keywords_desc']                     = 'De zoekmachine keyword(s), meerdere keywords scheiden met een komma.';
$_lang['seopackage.resource_index']                             = 'Zoekmachines mogen deze pagina indexeren';
$_lang['seopackage.resource_index_desc']                        = 'Indien aangevinkt zullen externe zoekmachines zoals Google of Yandex deze pagina indexeren.';
$_lang['seopackage.resource_follow']                            = 'Zoekmachines mogen de links op deze pagina volgen';
$_lang['seopackage.resource_follow_desc']                       = 'Indien aangevinkt zullen externe zoekmachines zoals Google of Yandex de links op deze pagina volgen en eventueel indexeren.';
$_lang['seopackage.resource_searchable']                        = 'Tonen in interne zoekmachines';
$_lang['seopackage.resource_searchable_desc']                   = 'Indien aangevinkt zal de pagina getoond worden in de eventuele interne zoekmachines.';
$_lang['seopackage.resource_sitemap']                           = 'Tonen in de sitemap';
$_lang['seopackage.resource_sitemap_desc']                      = 'Indien aangevinkt zal de pagina getoond worden in de sitemap.';
$_lang['seopackage.resource_sitemap_prio']                      = 'Sitemap prioriteit';
$_lang['seopackage.resource_sitemap_prio_desc']                 = 'Geef zoekmachines een indicatie van het belang van deze pagina door de prioriteit in te stellen. Let op: je prioriteit wordt niet blindelings overgenomen door zoekmachines!';
$_lang['seopackage.resource_sitemap_freq']                      = 'Sitemap update frequentie';
$_lang['seopackage.resource_sitemap_freq_desc']                 = 'Geef zoekmachines een indicatie hoevaak deze pagina gewijzigd word door de update frequentie in te stellen. Let op: je update frequentie wordt niet blindelings overgenomen door zoekmachines!';
$_lang['seopackage.seo_preview']                                = 'Zoekmachine voorbeeld ([[+type]])';
$_lang['seopackage.seo_preview_desc']                           = 'Voeg een omschrijving. Als je dat niet doet zal de zoekmachine proberen een relevant stukje uit de pagina te vinden om te tonen in de zoekresultaten.';
$_lang['seopackage.resource_allowed_chars']                     = 'Karakters';
$_lang['seopackage.resource_allowed_keywords']                  = 'Zoekmachine keyword(s)';

$_lang['seopackage.filter_context']                             = 'Filter op context...';
$_lang['seopackage.filter_files']                               = 'Bestanden tonen';
$_lang['seopackage.errors_clean_desc']                          = 'Deze functie maakt het mogelijk om 404 pagina\'s, die niet meer bezocht zijn sinds het opgegeven aantal dagen, te verwijderen. Deze actie kan niet worden teruggedraaid!';
$_lang['seopackage.errors_clean_executing']                     = 'Bezig met opruimen van 404 pagina\'s';
$_lang['seopackage.errors_clean_success']                       = '[[+amount]] 404 pagina(\'s) verwijderd.';
$_lang['seopackage.migrate_redirections']                       = 'Bestaande pagina\'s migreren';
$_lang['seopackage.migrate_redirections_confirm']               = 'Weet je zeker dat je alle bestaande pagina\'s wilt migreren?';
$_lang['seopackage.migrate_redirections_success']               = '[[+urls]] URL\'s en [[+pages]] pagina\'s gemigreerd.';
$_lang['seopackage.seo_preview_not_allowed']                    = 'Zoekmachines mogen deze pagina niet indexeren en daarom is er dus geen preview mogelijk.';
$_lang['seopackage.seo_sitemap_prio_high']                      = '1.0 - Hoog';
$_lang['seopackage.seo_sitemap_prio_normal']                    = '0.5 - Normaal';
$_lang['seopackage.seo_sitemap_prio_low']                       = '0.25 - Laag';
$_lang['seopackage.seo_sitemap_freq_always']                    = 'Altijd';
$_lang['seopackage.seo_sitemap_freq_hourly']                    = 'Ieder uur';
$_lang['seopackage.seo_sitemap_freq_daily']                     = 'Dagelijks';
$_lang['seopackage.seo_sitemap_freq_weekly']                    = 'Wekelijks';
$_lang['seopackage.seo_sitemap_freq_monthly']                   = 'Maandelijks';
$_lang['seopackage.seo_sitemap_freq_yearly']                    = 'Jaarlijks';
$_lang['seopackage.seo_sitemap_freq_never']                     = 'Nooit';
