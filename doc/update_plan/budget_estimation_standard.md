# PHP・CodeIgniterアップデート プロジェクト予算見積もり書

## 一般的な人月単価（80万円/人月、工期1.5ヶ月）

## 1. 見積もり概要

### プロジェクト基本情報
- **プロジェクト名**: PHP・CodeIgniterアップデートプロジェクト
- **総開発工数**: 5.3人月
- **開発期間**: 約1.5ヶ月
- **参加エンジニア数**: 4名
- **人月単価**: 80万円/人月
- **見積もり作成日**: 2025年6月20日

## 2. 総予算見積もり

| 項目 | 工数 | 単価 | 金額 | 比率 |
|------|------|------|------|------|
| **開発工数コスト** | **5.3人月** | **80万円** | **424万円** | **99.5%** |
| **基盤構築・準備** | | | | |
| 　- 開発環境のコンテナ化 | 0.5人月 | 80万円 | 40万円 | 9.4% |
| 　- 現状評価と準備 | 0.5人月 | 80万円 | 40万円 | 9.4% |
| **機能実装** | | | | |
| 　- 共通コンポーネント移行 | 0.6人月 | 80万円 | 48万円 | 11.3% |
| 　- 基本表示機能移行 | 0.32人月 | 80万円 | 25.6万円 | 6.0% |
| 　- レーサー管理機能移行 | 0.4人月 | 80万円 | 32万円 | 7.5% |
| 　- レース管理機能移行 | 0.4人月 | 80万円 | 32万円 | 7.5% |
| 　- 大会管理機能移行 | 0.4人月 | 80万円 | 32万円 | 7.5% |
| 　- ポイントシリーズ機能移行 | 0.32人月 | 80万円 | 25.6万円 | 6.0% |
| 　- ランキング機能移行 | 0.36人月 | 80万円 | 28.8万円 | 6.8% |
| **品質保証・リリース** | | | | |
| 　- テストと最終調整 | 1.0人月 | 80万円 | 80万円 | 18.8% |
| 　- 本番環境への展開 | 0.5人月 | 80万円 | 40万円 | 9.4% |
| **直接コスト** | | | **1.99万円** | **0.5%** |
| 　- GitHub Copilot Business（1.5ヶ月） | - | $19/月×4名 | 1.65万円 | 0.4% |
| 　- GitHub Organization（1.5ヶ月） | - | $4/月×4名 | 0.35万円 | 0.1% |
| **総予算** | | | **425.99万円** | **100%** |

※ 為替レート: 1ドル=145円で計算

## 3. コスト削減要因

### AIエージェント活用による効率化
- **効率化率**: 25-30%
- **従来工数**: 約7.1-7.6人月相当
- **削減工数**: 約1.8-2.3人月
- **削減効果**: 約144-184万円の削減

### 段階的移行によるリスク軽減
- 大規模な一括移行と比較して約20%のリスク軽減
- 予期しない追加工数の発生確率を大幅に低減

## 4. 注意事項・前提条件

### 見積もり前提条件
1. **工数**: tasks_estimation.csvに基づく詳細工数積算
2. **期間**: 1.5ヶ月間での完了を想定
3. **人員**: 4名のエンジニアチームでの並行作業
4. **為替レート**: 1ドル=145円（2025年6月時点）

### 追加費用が発生する可能性がある項目
1. **要件変更**: 仕様変更による追加開発
2. **インフラ費用**: 本番環境のクラウド利用料
3. **第三者ライブラリ**: 有償ライブラリの導入が必要な場合
4. **セキュリティ監査**: 外部セキュリティ監査が必要な場合

### 費用に含まれないもの
- 本番環境のサーバー・クラウド利用料
- SSL証明書費用
- ドメイン費用
- 運用・保守費用（移行完了後）

## 5. ROI（投資対効果）分析

### セキュリティリスク回避効果
- **PHP 5.3サポート終了**: セキュリティ脆弱性による潜在的損失回避
- **推定回避効果**: 年間100-500万円相当

### 保守性向上効果
- **開発効率向上**: 新機能開発時間の30-40%短縮
- **バグ修正効率**: デバッグ時間の20-30%短縮
- **年間保守コスト削減**: 50-100万円相当

### 総合的なROI
- **1年目**: 投資回収率 35-60%
- **3年間累計**: 投資回収率 200-400%

## 6. まとめ

本プロジェクトは、レガシーシステムの技術的負債を解消し、将来的な保守性とセキュリティを大幅に向上させる重要な投資です。

**総予算425.99万円**で、PHP 5.3からPHP 8.x、CodeIgniter 3からCodeIgniter 4への完全移行を実現し、長期的な技術的安定性とセキュリティを確保できます。AIエージェントの活用により、品質を維持しながら効率的な開発が期待できます。
