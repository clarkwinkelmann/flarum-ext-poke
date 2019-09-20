import {extend} from 'flarum/extend';
import app from 'flarum/app';
import UserCard from 'flarum/components/UserCard';
import Button from 'flarum/components/Button';
import UserControls from 'flarum/utils/UserControls';
import NotificationGrid from 'flarum/components/NotificationGrid';
import PokeNotification from './components/PokeNotification';

app.initializers.add('clarkwinkelmann/flarum-ext-poke', () => {
    extend(UserCard.prototype, 'infoItems', function (items) {
        if (app.forum.attribute('clarkwinkelmannPokeCanPoke')) {
            items.add('clarkwinkelmann-poke-button', Button.component({
                className: 'Button',
                children: app.translator.trans('clarkwinkelmann-poke.forum.profile.poke'),
                icon: 'fas fa-hand-point-left',
                onclick: () => {
                    app.request({
                        url: app.forum.attribute('apiUrl') + '/users/' + this.props.user.id() + '/poke',
                        method: 'POST',
                    }).then(data => {
                        app.store.pushPayload(data);
                        m.redraw();

                        alert(app.translator.trans('clarkwinkelmann-poke.forum.profile.sent'));
                    });
                },
            }));
        }

        items.add('clarkwinkelmann-poke-count', m('span', app.translator.trans('clarkwinkelmann-poke.forum.profile.count', {
            count: this.props.user.attribute('clarkwinkelmannPokeCount') + '', // Cast to string to preserve zero
        })));
    });

    extend(UserControls, 'moderationControls', (items, user) => {
        if (app.forum.attribute('clarkwinkelmannPokeCanReset')) {
            items.add('clarkwinkelmann-poke', Button.component({
                icon: 'fas fa-hand-point-left',
                children: app.translator.trans('clarkwinkelmann-poke.forum.profile.reset'),
                onclick() {
                    app.request({
                        url: app.forum.attribute('apiUrl') + '/users/' + user.id() + '/poke-reset',
                        method: 'POST',
                    }).then(() => {
                        alert(app.translator.trans('clarkwinkelmann-poke.forum.profile.reseted'));
                    });
                },
            }));
        }
    });

    app.notificationComponents['clarkwinkelmann-poke'] = PokeNotification;

    extend(NotificationGrid.prototype, 'notificationTypes', function(items) {
        items.add('clarkwinkelmann-poke', {
            name: 'clarkwinkelmann-poke',
            icon: 'fas fa-hand-point-left',
            label: app.translator.trans('clarkwinkelmann-poke.forum.settings.poke')
        });
    });
});
