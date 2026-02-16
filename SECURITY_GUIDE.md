# 🔐 Security Quick Reference

## ⚠️ NEVER Commit These to Git

### Blockchain/Crypto
- ❌ Private keys (EVM, Bitcoin, Solana, etc.)
- ❌ 12/24 word seed phrases (mnemonics)
- ❌ Wallet keystores without encryption
- ❌ Recovery phrases
- ❌ Hardware wallet PINs

### API & Services
- ❌ API keys and secrets
- ❌ Access tokens (GitHub, AWS, etc.)
- ❌ OAuth client secrets
- ❌ Database passwords
- ❌ Service account credentials

### Files to Avoid
- ❌ `.env` files (unless it's `.env.example`)
- ❌ `credentials.json`
- ❌ `secrets.yaml`
- ❌ `config.local.*` files
- ❌ Any file named with "key", "secret", "token", "password"

---

## ✅ Safe Alternatives

### For Development
```bash
# Use environment variables
export PRIVATE_KEY="your-key-here"  # In terminal only, never in files

# Use .env files (add to .gitignore!)
echo ".env" >> .gitignore
```

### For Production
- Use environment variables on hosting platform
- Use secret management services (AWS Secrets Manager, HashiCorp Vault)
- Use encrypted keystores with passwords stored separately
- Use hardware wallets for high-value operations

---

## 🚨 What to Do If You Accidentally Committed Secrets

### Immediate Actions (First 5 Minutes)
1. **🔥 Assume the secret is compromised**
2. **🔄 Rotate/invalidate the credential IMMEDIATELY**
   - For blockchain: Transfer all funds to a NEW wallet
   - For API keys: Revoke and generate new keys
3. **⏸️ Stop all services using that credential**

### Clean Git History
```bash
# For the most recent commit (not yet pushed):
git reset --soft HEAD~1
git reset HEAD <file-with-secret>
# Edit file to remove secret
git add .
git commit -m "Remove sensitive data"

# For already pushed commits:
# USE WITH CAUTION - Rewrites history
# Consider using BFG Repo-Cleaner or git-filter-repo
```

### After Cleanup
1. Force push if you rewrote history (coordinate with team!)
2. Verify secret is gone: `git log -p | grep "pattern"`
3. Monitor for unauthorized access
4. Update all team members
5. Document the incident

---

## 🛡️ Prevention Tools

### Pre-commit Hooks
```bash
# Install git-secrets
brew install git-secrets  # macOS
# or
apt-get install git-secrets  # Linux

# Setup
git secrets --install
git secrets --register-aws
```

### GitHub Features
- ✅ Enable secret scanning (Settings → Code security)
- ✅ Enable push protection
- ✅ Review security advisories

---

## 📋 Pre-Push Checklist

Before pushing code with new files:

- [ ] Reviewed all changed files
- [ ] No hardcoded credentials
- [ ] No private keys or mnemonics
- [ ] Sensitive data in environment variables only
- [ ] .gitignore updated if needed
- [ ] No TODO comments with credentials
- [ ] No debug logs with sensitive data

---

## 🔍 Quick Self-Audit

Run these commands to check your repo:

```bash
# Check current files for common patterns
grep -r -i "private.?key" .
grep -r -i "0x[a-fA-F0-9]\{64\}" .
grep -r -i "mnemonic" .

# Check what files are staged
git status

# Review what you're about to commit
git diff --cached
```

---

## 📚 Learn More

- [GitHub Secret Scanning](https://docs.github.com/en/code-security/secret-scanning)
- [OWASP Secrets Management Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Secrets_Management_Cheat_Sheet.html)
- [BIP39 Mnemonic Security](https://github.com/bitcoin/bips/blob/master/bip-0039.mediawiki)
- [AWS Secrets Manager](https://aws.amazon.com/secrets-manager/)

---

**Remember:** Once a secret is committed to git, assume it's compromised. The only safe action is to rotate it immediately.
