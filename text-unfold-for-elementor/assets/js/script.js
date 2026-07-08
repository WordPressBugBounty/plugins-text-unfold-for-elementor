jQuery(function ($) {
    class TextUnfoldWidgetHandlerClass extends elementorModules.frontend.handlers.Base {
        getDefaultSettings() {
            return {
                selectors: {
                    readMoreSelector: '.fswp-elt--read-more',
                },
            };
        }

        getDefaultElements() {
            const selectors = this.getSettings('selectors');
            return {
                $readMoreSelector: this.$element.find(selectors.readMoreSelector),
            };
        }

        findElement(selector) {
            const $mainElement = this.$element;
            return $mainElement.find(selector).filter(function () {
                return $(this).closest('.elementor-element').is($mainElement);
            });
        }

        bindEvents() {
            let content        = this.findElement('.fswp-elt--read-more-content');
            let overlay        = this.findElement('.fswp-elt--read-more-overlay');
            let readMoreButton = this.elements.$readMoreSelector;

            // No Read More button rendered (option disabled) — leave content untouched
            if (!readMoreButton.length) {
                content.css({ height: 'auto', overflow: 'visible' });
                return;
            }

            let readMoreText   = readMoreButton.data('more');
            let readLessText   = readMoreButton.data('less');
            let handler        = this;

            // Auto-hide button if content is shorter than container height
            let containerHeight = parseInt(readMoreButton.data('height')) || 100;
            let naturalHeight   = content.css('height', 'auto').height();
            content.height(containerHeight);
            if (naturalHeight <= containerHeight) {
                readMoreButton.closest('.fswp-elt--read-more-button-wrapper').hide();
                overlay.hide();
                content.css('overflow', 'visible');
                return;
            }

            readMoreButton.on('click', function (e) {
                e.preventDefault();
                let btnHeight = parseInt(handler.elements.$readMoreSelector.data('height')) || 100;
                $(this).toggleClass('more');

                if (!$(this).hasClass('more')) {
                    // Expanding
                    let fullHeight = content.css('height', 'auto').height();
                    content.height(btnHeight);
                    overlay.fadeOut(200);
                    content.animate({ height: fullHeight }, 200);
                    $(this).find('.fswp-elt--read-more-text').html(readLessText);
                    $(this).attr('aria-expanded', 'true');
                    if ($(this).hasClass('show-icon')) {
                        $(this).find('.fswp-elt--read-more-icon.more').hide();
                        $(this).find('.fswp-elt--read-more-icon.less').show();
                    }
                } else {
                    // Collapsing
                    overlay.fadeIn(200);
                    content.animate({ height: btnHeight }, 200);
                    $(this).find('.fswp-elt--read-more-text').html(readMoreText);
                    $(this).attr('aria-expanded', 'false');
                    if ($(this).hasClass('show-icon')) {
                        $(this).find('.fswp-elt--read-more-icon.more').show();
                        $(this).find('.fswp-elt--read-more-icon.less').hide();
                    }
                }
            });
        }
    }

    if (window.elementorFrontend) {
        elementorFrontend.elementsHandler.attachHandler('fswp-text-unfold', TextUnfoldWidgetHandlerClass);
        if (elementorFrontend.isEditMode()) {
            elementor.hooks.addAction('panel/open_editor/widget/fswp-text-unfold', function (panel, model, view) {
                let height = model.attributes.settings.attributes.height['size'];
                panel.$el.on('click change keyup keydown input', function () {
                    let newHeight = model.attributes.settings.attributes.height['size'];
                    if (height !== newHeight) {
                        height = newHeight;
                        $(view.el).find('.fswp-elt--read-more').data('height', height);
                        if ($(view.el).find('.fswp-elt--read-more').hasClass('more')) {
                            $(view.el).find('.fswp-elt--read-more-content').height(height);
                        }
                    }
                });
            });
        }
    }
});
