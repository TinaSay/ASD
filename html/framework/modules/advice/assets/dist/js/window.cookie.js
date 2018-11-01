// helper cookie functions
window.utils = {};
window.utils.Cookie = {
    get: function (n) {
        var c = document.cookie, e, p = n + "=", b;

        // Strict mode
        if (!c)
            return "";

        b = c.indexOf("; " + p);

        if (b == -1) {
            b = c.indexOf(p);

            if (b != 0)
                return "";
        } else
            b += 2;

        e = c.indexOf(";", b);

        if (e == -1)
            e = c.length;

        return decodeURIComponent(c.substring(b + p.length, e));
    },

    set: function (n, v, e, p, d, s) {
        var time = new Date();
        time.setTime(time.getTime() + e * 1000);
        document.cookie = n + "=" + encodeURIComponent(v) +
            ((e) ? "; expires=" + time.toGMTString() : "") +
            ((p) ? "; path=" + escape(p) : "") +
            ((d) ? "; domain=" + d : "") +
            ((s) ? "; secure" : "");
    },

    remove: function (n, p) {
        var d = new Date();
        d.setTime(d.getTime() - 1000);
        this.set(n, '', d, p, d);
    }

};