<? defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php')); ?>
<div class="form_box">
    <? if (!F_LOGGED): ?>
        <div class="b-overlay" id="popup_overlay">
            <div class="b-popup is-hidden" id="popup_login">
                <div class="b-popup__close"></div>
                <div class="b-popup__header">Войти</div>
                <div class="b-popup-content">
                    <div class="b-login">
                        <form class="b-login-form" id="sign_form" name="sign_form">
                            <div class="b-login-form-item">
                                <label for="login" class="b-login-form__label">Email*</label>
                                <input
                                    type="text" class="b-login-form__input b-input" name="email" id="login" placeholder="Email">
                            </div>
                            <div class="b-login-form-item">
                                <label for="password" class="b-login-form__label">Пароль*</label>
                                <input
                                    type="password" class="b-login-form__input b-input" name="pass" id="password" placeholder="Пароль">
                                <div class="b-login-form-item__icon icon-eye" data-icon="show_pass"></div>
                                <div class="b-login-form-item__error" id="sign_error"></div>
                                <a class="b-login-form-item__hint" id="sign_restore">Забыли пароль?</a>
                            </div>
                            <input type="hidden" name="auth_type" value="1" />
                            <button class="b-button b-button_red" id="sign_login" href="#js">Войти</button>
                        </form>
                    </div>
                    <div class="b-social-login">
                        <div class="b-social-login__header">Или с помощью:</div>
                        <div class="b-social-login-icons">
                            <a href="" class="b-social-login-icons__item icon-facebook"></a>
                            <a href="" class="b-social-login-icons__item icon-pinterest"></a>
                            <a href="" class="b-social-login-icons__item icon-vkontakte"></a>
                        </div>
                        <span class="b-social-login__hint">Нет аккаунта?</span><a class="b-social-login__link" data-el="create_popup_trigger">Создать</a>
                    </div>
                </div>
            </div>
            <div class="b-popup is-hidden" id="popup_registration">
                <div class="b-popup__close"></div>
                <div class="b-popup__header">Регистрация</div>
                <div class="b-popup__text">Ты сможешь открыть для себя мир замечательной стильной одежды и аксессуаров от вещуших стилистов</div>
                <div class="b-popup-content">
                    <div class="b-login">
                        <form class="b-login-form" id="reg_form" name="reg_form">
                            <div class="b-login-form-item">
                                <label for="fio" class="b-login-form__label">Имя и фамилия*</label>
                                <input
                                    type="text" class="b-login-form__input b-input" id="fio" name="fio" id="login" placeholder="">
                            </div>
                            <div class="b-login-form-item">
                                <label for="login_reg" class="b-login-form__label">Email*</label>
                                <input
                                    type="text" class="b-login-form__input b-input" name="login" id="login_reg" placeholder="Email">
                            </div>
                            <div class="b-login-form-item">
                                <label for="password_reg" class="b-login-form__label">Пароль*</label>
                                <input
                                    type="password" class="b-login-form__input b-input" name="pass" id="password_reg" placeholder="Пароль">
                                <div class="b-login-form-item__icon icon-eye" data-icon="show_pass"></div>
                                <div class="b-login-form-item__error" id="reg_error"></div>
                            </div>
                            <input type="hidden" name="auth_type" value="1" />
                            <button class="b-button b-button_red" id="sign_reg" href="#js">Регистрация</button>
                        </form>
                    </div>
                    <div class="b-social-login">
                        <div class="b-social-login__header">Или с помощью:</div>
                        <div class="b-social-login-icons">
                            <a href="" class="b-social-login-icons__item icon-facebook"></a>
                            <a href="" class="b-social-login-icons__item icon-pinterest"></a>
                            <a href="" class="b-social-login-icons__item icon-vkontakte"></a>
                        </div>
                        <span class="b-social-login__hint">Уже есть аккаунт?</span><a class="b-social-login__link" data-el="login_trigger">Войти</a>
                    </div>
                </div>
            </div>
            <div class="b-popup is-hidden" id="restore_popup">
                <div class="b-popup__close"></div>
                <div class="b-popup__header">Восстановление пароля</div>
                <div class="b-popup__text">Укажи емейл, на который зарегистрирован профайл.<br/> Мы вышлем тебе новый пароль</div>
                <div class="b-popup-content">
                    <div class="b-login b-login_wrapped">
                        <form class="b-login-form" id="rec_form" name="rec_form">
                            <div class="b-login-form-item">
                                <label for="password_rec" class="b-login-form__label">Email*</label>
                                <input
                                    type="text" class="b-login-form__input b-input" id="password_rec" name="login">
                                <div class="b-login-form-item__icon icon-write"></div>
                                <div class="b-login-form-item__icon icon-wrong"></div>
                                <div class="b-login-form-item__error" id="rec_error"></div>
                            </div>
                            <input type="hidden" name="auth_type" value="1" />
                            <button class="b-button b-button_green" id="sign_rec" href="#js">Прислать пароль</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <? endif; ?>
</div>