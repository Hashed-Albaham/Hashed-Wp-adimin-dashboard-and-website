function toArabicTime(a) {
    var b = a, c = "", d = "", e = "", f = "";
    if ("" === a) return "";
    0 <= a.indexOf("d") && (b = a.split("d"), c = "" !== b[0] ? b[0] + " يوم " : "", b = b[1]);
    0 <= a.indexOf("h") && (b = b.split("h"), d = "" !== b[0] ? b[0] + " ساعة " : "", b = b[1]);
    0 <= a.indexOf("m") && (b = b.split("m"), e = "" !== b[0] ? b[0] + " دقيقة " : "", b = b[1]);
    0 <= a.indexOf("s") && (a = b.split("s"), f = "" !== a[0] ? a[0] + " ثانية " : "");
    return c + d + e + f
}

function toArabicBytes(a) {
    return 1024 > a ? a + " بايت " : 1048576 > a ? Math.round(a / 1024) + " كيلوبايت " : 1073741824 > a ? Math.round(a / 1048576) + " ميجابايت " : Math.round(a / 1073741824) + " جيجابايت "
}

function toArabicError(a) {
    return 0 <= a.indexOf("user") && 0 <= a.indexOf("not found") ? "لقد ادخلت الكرت بطريقة غير صحيحة، الرجاء المحاولة مرة اخرى" : 0 <= a.indexOf("simultaneous session limit reached") || 0 <= a.indexOf("no more sessions are allowed") ? "المعذرة ، هذا الكرت مستخدم حالياً في جهاز آخر" :
        0 <= a.indexOf("invalid password") ? "تاكد من كتابة كلمة المرور بشكل صحيح" : 0 <= a.indexOf("uptime limit reached") ? "عذراً لقد انتهى الوقت المتاح لك.." : 0 <= a.indexOf("uptime limit") ? "لقد انتهى رصيد هذا الحساب" :
            0 <= a.indexOf("invalid username or password") ? "خطأ في كلمة المرور" : 0 <= a.indexOf("traffic limit") || 0 <= a.indexOf("transfer limit reached") ? "لقد انتهى رصيد التحميل لهذا الكرت" : 0 <= a.indexOf("no valid profile found") ? "لقد انتهت صلاحية هذا الكرت" :
                0 <= a.indexOf("not found") ? "لقد ادخلت اسم المستخدم بطريقة غير صحيحة، الرجاء المحاولة مرة اخرى" : 0 <= a.indexOf("invalid Calling-Station-Id") ? "هذا الحساب مقترن بجهاز آخر!" :
                    0 <= a.indexOf("server") && 0 <= a.indexOf("is") && 0 <= a.indexOf("not") && 0 <= a.indexOf("responding") ? "يرجى الانتظار، يتم الآن اعادة تشغيل الشبكة، هذه العملية قد تستغرق بعض الوقت" : 0 <= a.indexOf("web") &&
                    0 <= a.indexOf("browser") && 0 <= a.indexOf("did") && 0 <= a.indexOf("not") && 0 <= a.indexOf("send") ? "يرجى محاولة ادخال الكرت مرة اخرى" : "حصل خطا :" + a
}

function hideHalfCard(a) {
    a = a.toLowerCase();
    if (0 <= a.indexOf("T-")) return "تجربة مجانية";
    if (0 <= a.indexOf(":")) return "اشتراك";
    var b = Math.ceil(a.length / 2);
    a = a.substring(0, b);
    return a += "*".repeat(b)
};
var c = window.pageYOffset;
window.addEventListener("scroll", function () {
    var b = window.pageYOffset;
    document.getElementById("navbar").style.top = c > b ? "0" : "-50px";
    c = b
});
