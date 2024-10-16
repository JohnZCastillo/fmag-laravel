if (typeof window === "undefined") {
    // note: this code should never be called, unless somehow the customer manages to use a bundler
    // that doesn't read the package.json "browser" field.
    throw new Error("[TalkJS] The TalkJS JavaScript SDK only works in browsers (and not, for example, in Node.js)");
}

// Snippet[starts]
(function(t,a,l,k,j,s){
    s=a.createElement("script");s.async=1;s.src="https://cdn.talkjs.com/talk.js";a.head.appendChild(s);k=t.Promise;
    t.Talk={v:3,ready:{then:function(f){if(k)return new k(function(r,e){l.push([f,r,e]);});l.push([f]);},catch:function(){return k&&new k();},c:l}};
})(window,document,[]);
// Snippet[ends]

module.exports = window.Talk;
