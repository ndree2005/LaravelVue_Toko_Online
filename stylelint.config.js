// stylelint.config.js
module.exports = {
  rules: {
    'at-rule-no-unknown': [true, {
      ignoreAtRules: ['import', 'source', 'tailwindcss', 'layer', 'apply']
    }]
  }
}