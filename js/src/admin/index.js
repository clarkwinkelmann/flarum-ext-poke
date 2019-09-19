import {extend} from 'flarum/extend';
import app from 'flarum/app';
import PermissionGrid from 'flarum/components/PermissionGrid';

app.initializers.add('clarkwinkelmann/flarum-ext-poke', () => {
    extend(PermissionGrid.prototype, 'replyItems', items => {
        items.add('clarkwinkelmann-poke', {
            icon: 'fas fa-hand-point-left',
            label: app.translator.trans('clarkwinkelmann-poke.admin.permissions.poke'),
            permission: 'clarkwinkelmann-poke.poke',
        });
    });

    extend(PermissionGrid.prototype, 'moderateItems', items => {
        items.add('clarkwinkelmann-poke', {
            icon: 'fas fa-hand-point-left',
            label: app.translator.trans('clarkwinkelmann-poke.admin.permissions.reset'),
            permission: 'clarkwinkelmann-poke.reset',
        });
    });
});
