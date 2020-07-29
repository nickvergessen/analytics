import Vue from 'vue';
import { translate, translatePlural } from '@nextcloud/l10n';

import App from './App';

Vue.prototype.t = translate;
Vue.prototype.n = translatePlural;

OCA.Analytics.Sidebar.ShareNew = {

    // hier in nem neuen arbeiten?
    // bin auch hier...
    tabContainerShareNeu: function() {
        // const datasetId = document.getElementById('app-sidebar').dataset.id;

        OCA.Analytics.Sidebar.resetView();
        document.getElementById('tabHeaderShareNew').classList.add('selected');
        document.getElementById('tabContainerShareNew').classList.remove('hidden');

        // eslint-disable-next-line
        const app = new Vue({
            el: '.tabContainerShareNew',
            render: h => h(App),
        });
    },

};

OCA.Analytics.Sidebar.registerSidebarTab({
    id: 'tabHeaderShareNew',
    class: 'tabContainerShareNew',
    tabindex: '5',
    name: t('analytics', 'Share new'),
    action: OCA.Analytics.Sidebar.ShareNew.tabContainerShareNeu,
});
