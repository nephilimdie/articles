# AgileFlow - A Git Branching Strategy for Agile Teams

Modern Agile teams often struggle to find the right balance between flexibility and structure in their Git workflows. While GitFlow introduces too much overhead for fast-paced iterations, Trunk-Based Development often lacks the traceability and coordination needed by QA and product teams.

**AgileFlow** provides a lightweight but structured alternative. It defines clear rules for task breakdown, branch naming, version tagging, and automated release notes — perfectly aligned with Agile delivery models.

## 🧱 Branch Structure

AgileFlow defines a clear and modular branch structure designed to support Agile workflows with short-lived, traceable, and purpose-specific branches. Each branch type has a distinct and well-defined role in the development lifecycle. This structured approach ensures clarity for the team, facilitates automation, and enables traceability from code to business requirements.

### Branch Types

| Branch Type | Purpose |
| ----------- | ------- |
| `master` | This is the main branch representing production-ready code. It always reflects the latest stable version of the application and is tagged accordingly. |
| `feature/` | Represents a new functionality or Epic. It is a parent branch that groups several `task/` branches related to the same business objective. |
| `task/` | A small, focused unit of development work (maximum 8 hours) implementing a single method or business logic. Tied to a specific ticket or user story. |
| `bugfix/` | Branches created when QA identifies an issue during feature testing. They are merged back into their respective `feature/` branches. |
| `hotfix/` | Created directly from `master` to immediately address issues found in production. Typically triggers a patch version bump. |
| `release/` | Temporary branches used to prepare a new version. They aggregate tested `feature/` and `hotfix/` branches and serve as the final staging area before merging into `master`. |

## 🔄 Merge Strategy (Updated)

In AgileFlow, each branch type follows a precise merge process to ensure clarity, traceability, and consistency across all stages of development.

### 🧩 1. Feature Workflow

![Feature Workflow](./feature-workflow.png)

### 🛠️ 2. Hotfix Workflow

![Hotfix Workflow](./hotfix-workflow.png)

### 🚀 3. Release Workflow

![Release Workflow](./release-workflow.png)

### 📊 Merge Matrix

| From | To | When | Version Impact |
|------|----|------|----------------|
| `task/*` | `feature/*` | After task completion | None |
| `bugfix/*` | `feature/*` | After QA finds and reports an issue | None |
| `feature/*` | `release/*` | Once all tasks are complete and validated | MINOR bump |
| `release/*` | `master` | After sprint completion | MINOR or MAJOR bump |
| `hotfix/*` | `master` | Immediately after fix is tested | PATCH bump |
| `hotfix/*` | `release/*` | If a release branch is open | PATCH bump (duplicated) |

## ✏️ Commit Convention

AgileFlow uses structured commit messages to improve readability, traceability, and automation.

```bash
type(scope): message
```

Examples:

```bash
feat(checkout): add billing step
fix(auth): resolve login crash
refactor(cart): extract calculator method
```

## 🧾 Release Notes Automation

Key benefits:

- ✅ Fully automated from developer input (no extra work)
- ✅ Includes ticket IDs, titles, and scope of change
- ✅ Categorizes changes into Features, Fixes, Refactors, etc.
- ✅ Helps QA and PMs track progress and impact

### Example Release Note

```
📦 Version 1.4.0 (2025-08-05)
-----------------------------
✨ Features
- [12345] Checkout flow improvements
- [12346] Shipping calculation

🐛 Fixes
- [12350] Login crash on session timeout

🔧 Refactors
- [12347] Simplified cart logic
```

## 📦 Versioning Strategy (SemVer)

| Change Type | Branch Trigger | Resulting Version Bump |
|-------------|----------------|-------------------------|
| Breaking API Change | Any (with annotation) | MAJOR ↑ |
| New Functionality | `feature/`, `release/` | MINOR ↑ |
| Bugfix | `hotfix/` | PATCH ↑ |

## 🧠 How This Enables Agile Teams

Benefits include:

- ⏱️ Smaller PRs and faster reviews
- 📦 Clear visibility of what gets released
- 🧪 Precise targeting of what to test
- 🧩 Easy rollback via task-based history

## 🛠️ Tooling & Compatibility

AgileFlow works with:

- ✅ GitHub / GitLab
- ✅ GitHub Actions / GitLab CI
- ✅ Jira, TargetProcess, Linear, etc.
- ✅ Conventional Commits
- ✅ Release Drafter, semantic-release, changelog generators

Optionally, it can be extended with:

- Git hooks to enforce naming patterns
- Monorepo support via folder-based scoping
- GitHub PR templates auto-filled from branch names