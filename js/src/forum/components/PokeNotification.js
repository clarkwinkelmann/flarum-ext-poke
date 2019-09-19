import Notification from 'flarum/components/Notification';

export default class PokeNotification extends Notification {
    icon() {
        return 'fas fa-hand-point-left';
    }

    href() {
        return app.route.user(this.props.notification.fromUser());
    }

    content() {
        return app.translator.trans('clarkwinkelmann-poke.forum.notifications.poke', {
            user: this.props.notification.fromUser(),
        });
    }
}
