export default class CookieManager {
    /**
     * Cria ou atualiza um cookie com nome, valor e número de dias para expiração.
     * 
     * @param {string} name - Nome do cookie.
     * @param {string} value - Valor do cookie.
     * @param {number} [days] - Número de dias para expiração. Se omitido, o cookie será deletado ao fechar o navegador.
     * @param {string} [path='/'] - Caminho onde o cookie está acessível.
     * @param {string} [domain] - Domínio em que o cookie é acessível.
     * @param {boolean} [secure] - Define se o cookie só é enviado em conexões HTTPS.
     * @param {string} [sameSite='Lax'] - Política de SameSite ('Lax', 'Strict', 'None').
     */
    static setCookie(name, value, days, path = '/', domain, secure = false, sameSite = 'Lax') {
        let expires = "";
        if (days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        const secureFlag = secure ? "; secure" : "";
        const domainFlag = domain ? "; domain=" + domain : "";
        const sameSiteFlag = sameSite ? "; samesite=" + sameSite : "";
        
        return document.cookie = `${name}=${value || ""}${expires}; path=${path}${domainFlag}${secureFlag}${sameSiteFlag}`;
    }

    /**
     * Retorna o valor de um cookie pelo nome.
     * 
     * @param {string} name - Nome do cookie a ser recuperado.
     * @returns {string|null} - Retorna o valor do cookie, ou null se não encontrado.
     */
    static getCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i].trim();
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    /**
     * Deleta um cookie pelo nome.
     * 
     * @param {string} name - Nome do cookie a ser deletado.
     * @param {string} [path='/'] - Caminho onde o cookie está acessível.
     * @param {string} [domain] - Domínio em que o cookie foi definido.
     */
    static deleteCookie(name, path = '/', domain) {
        // Define uma data de expiração passada para deletar o cookie
        this.setCookie(name, "", -1, path, domain);
    }

    /**
     * Lista todos os cookies disponíveis no documento.
     * 
     * @returns {Object} - Retorna um objeto com todos os cookies como pares chave-valor.
     */
    static listCookies() {
        const cookies = document.cookie.split(';');
        const cookieObj = {};
        cookies.forEach(cookie => {
            const [name, value] = cookie.split('=').map(c => c.trim());
            cookieObj[name] = value;
        });
        return cookieObj;
    }
}
